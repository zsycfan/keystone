<?php

namespace Keystone\Repository;
use \DB;

class Page
{

  public static function save(\Keystone\Entity\Page $page)
  {
    if ($page->id) {
      DB::table('pages')
        ->where('id', '=', $page->id)
        ->update(array('updated_at' => date('Y-m-d G:i:s')))
      ;
    }
    else {
      $page->id = DB::table('pages')->insert_get_id(array(
        'created_at' => date('Y-m-d G:i:s'),
        'updated_at' => date('Y-m-d G:i:s'),
      ));
    }

    $revision_id = DB::table('page_revisions')->insert_get_id(array(
      'page_id' => $page->id,
      'language' => $page->language,
      'layout' => $page->layout->name(),
      'title' => $page->title,
      'excerpt' => $page->excerpt,
      'regions' => $page->regions->json(),
      'created_at' => date('Y-m-d G:i:s'),
      'updated_at' => date('Y-m-d G:i:s'),
    ));

    $path = array(
      'revision_id' => $revision_id,
      'order' => null,
      'uri' => $page->uri
    );
    $segments = preg_split('#/#', $page->uri);
    foreach ($segments as $index => $seg) {
      $index++;
      $path["segment{$index}"] = $seg;
    }
    DB::table('page_paths')->insert($path);

    if ($page->published) {
      $row = DB::table('page_publishes')->where('page_id', '=', $page->id);
      if ($row) {
        DB::table('page_publishes')
          ->where('page_id', '=', $page->id)
          ->update(array(
            'revision_id' => $revision_id,
            'published_at' => date('Y-m-d G:i:s'),
        ));
      }
      else {
        DB::table('page_publishes')->insert_get_id(array(
          'page_id' => $page->id,
          'revision_id' => $revision_id,
          'published_at' => date('Y-m-d G:i:s'),
        ));
      }
    }
  }

  public static function all()
  {
    $page_objects = static::query()
      ->order_by('p.updated_at', 'desc')
      ->get()
    ;

    $pages = array();
    foreach ($page_objects as $page) {
      $pages[] = static::make_entity($page);;
    }

    return $pages;
  }

  public static function find_or_create($id, $params=array())
  {
    try {
      $page = static::find($id, $params);
    }
    catch (\Exception $e) {
      $page = new \Keystone\Entity\Page();
    }

    return $page;
  }

  public static function query($params=array())
  {
    $query = DB::table('pages AS p')
      ->select(array('*', 'pr.id AS active_revision', 'pu.revision_id AS published_revision', 'p.id'))
      ->join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->left_join('page_publishes AS pu', 'pu.page_id', '=', 'p.id')
    ;

    if (@$params['published']) {
      $query->where('pr.id', '=', DB::raw('`pu`.`revision_id`'));
    }
    else if (is_numeric(@$params['rev'])) {
      $query->where('pr.id', '=', $params['rev']);
    }
    else {
      $query->raw_where('`pr`.`id` = (SELECT MAX(`id`) FROM `page_revisions` AS `prc` WHERE `prc`.`page_id`=`p`.`id`)');
    }

    return $query;
  }

  public static function make_entity($page)
  {
    $entity = new \Keystone\Entity\Page();
    $entity->id = $page->id;
    $entity->language = $page->language;
    $entity->regions = new \Keystone\Regions(json_decode($page->regions, true));
    $entity->layout = new \Keystone\Layout($page->layout, $entity);
    $entity->published = $page->active_revision == $page->published_revision;
    $entity->published_at = $page->published_at;
    $entity->uri = $page->uri;
    $entity->title = $page->title;
    $entity->excerpt = $page->excerpt;
    return $entity;
  }

  public static function find($id, $params=array())
  {
    $page = static::query($params)->where('p.id', '=', $id)->take(1);

    if (($page = $page->first()) == false) {
      throw new \Exception('Entity not found.');
    }

    return static::make_entity($page);
  }

  public static function find_by_uri($uri, $params=array())
  {
    $page = static::query($params)->where('pp.uri', '=', $uri)->take(1);

    if (($page = $page->first()) == false) {
      throw new \Exception('Entity not found.');
    }

    return static::make_entity($page);
  }

  public static function find_by_title($title, $params=array())
  {
    $query = static::query($params);

    $words = preg_split('/\s+/', $title);
    foreach ($words as $word) {
      $query->where('pr.title', 'like', "%{$word}%");
    }

    if (($rows = $query->get()) == false) {
      return array();
    }

    $pages = array();
    foreach ($rows as $page) {
      $pages[] = static::make_entity($page);
    }

    return $pages;
  }

  public static function revisions($id)
  {
    $query = DB::table('page_revisions AS pr')
      ->select(array('*', 'pr.id AS active_revision', 'pu.revision_id AS published_revision', 'p.id'))
      ->join('pages AS p', 'p.id', '=', 'pr.page_id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->left_join('page_publishes AS pu', 'pu.page_id', '=', 'p.id')
      ->get()
    ;

    $revisions = array();
    foreach ($query as $rev) {
      $revisions[] = static::make_entity($rev);
    }

    return $revisions;
  }

}