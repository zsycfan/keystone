<?php

namespace Keystone\Repository;
use \DB;

class Page
{

  public static function save(\Keystone\Entity\Page $page)
  {
    // If the page exists in the database we'll just touch it's updated
    // timestamp to track the change
    if ($page->id) {
      DB::table('pages')
        ->where('id', '=', $page->id)
        ->update(array('updated_at' => date('Y-m-d G:i:s')))
      ;
    }

    // If the page doesn't exist in the database we'll create it
    else {
      $page->id = DB::table('pages')->insert_get_id(array(
        'created_at' => date('Y-m-d G:i:s'),
        'updated_at' => date('Y-m-d G:i:s'),
      ));
    }

    // Now add a revision containing all the data about the page
    $revision_id = DB::table('page_revisions')->insert_get_id(array(
      'page_id' => $page->id,
      'language' => $page->language,
      'layout' => $page->layout->name(),
      'title' => $page->title,
      'excerpt' => $page->excerpt,
      'regions' => $page->regions->json(),
      'order' => $page->order,
      'created_at' => date('Y-m-d G:i:s'),
      'updated_at' => date('Y-m-d G:i:s'),
    ));

    // Add a row to the path table to track the URI of this revision
    $path = array(
      'revision_id' => $revision_id,
      'uri' => $page->uri
    );
    $segments = array_filter(preg_split('#/#', $page->uri));
    foreach ($segments as $index => $seg) {
      $index++;
      $path["segment{$index}"] = $seg;
    }
    DB::table('page_paths')->insert($path);

    // If we're publishing the page then update the table of published revisions
    if ($page->published) {
      $row = DB::table('page_publishes')->where('page_id', '=', $page->id)->first();
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
      $pages[] = static::make_entity($page);
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
      ->select(array('p.*', 'pp.*', 'pu.*', 'pr.*', 'pr.id AS active_revision', 'pu.revision_id AS published_revision', 'pr.id AS revision_id', 'p.id'))
      ->join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->left_join('page_publishes AS pu', 'pu.page_id', '=', 'p.id')
    ;

    if (@$params['published']) {
      $query->where('pr.id', '=', DB::raw('`pu`.`revision_id`'));
    }
    else if (is_numeric(@$params['revision'])) {
      $query->where('pr.id', '=', $params['revision']);
    }
    else {
      $query->raw_where('`pr`.`id` = (SELECT MAX(`id`) FROM `page_revisions` AS `prc` WHERE `prc`.`page_id`=`p`.`id`)');
    }

    return $query;
  }

  public static function make_entity($page)
  {
    $entity = new \Keystone\Entity\Page();
    $entity->set_raw('id', $page->id);
    $entity->set_raw('published_id', $page->published_revision);
    $entity->set_raw('revision_id', $page->revision_id);
    $entity->set_raw('language', $page->language);
    $entity->set_raw('regions', new \Keystone\Regions(json_decode($page->regions, true)));
    $entity->set_raw('layout', new \Keystone\Layout($page->layout, $entity));
    $entity->set_raw('published', $page->published_revision == true);
    $entity->set_raw('published_at', $page->published_at);
    $entity->set_raw('uri', $page->uri);
    $entity->set_raw('title', $page->title);
    $entity->set_raw('excerpt', $page->excerpt);
    $entity->set_raw('order', $page->order);
    $entity->set_raw('created_at', $page->created_at);
    $entity->set_raw('created_since', date_create('now')->diff(new \DateTime($page->created_at)));
    $entity->set_raw('updated_at', $page->updated_at);
    $entity->set_raw('updated_since', date_create('now')->diff(new \DateTime($page->updated_at)));
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

  public static function find_at_uri($uri, $params=array())
  {
    $segments = array_filter(preg_split('#/#', $uri));

    $page_objects = static::query($params)->order_by('order', 'asc');

    if (!count($segments)) {
      $page_objects->where_not_null('pp.segment1');
      $page_objects->where_null('pp.segment2');
    }
    else {
      foreach ($segments as $index => $segment) {
        $page_objects->where('pp.segment'.++$index, '=', $segment);
      }
      $page_objects->where_not_null('pp.segment'.++$index);
      $page_objects->where_null('pp.segment'.++$index);
    }

    $page_objects = $page_objects->get();

    if (count($page_objects) == 0) {
      throw new \Exception("No pages found at [{$uri}].");
    }

    $pages = array();
    foreach ($page_objects as $page) {
      $pages[] = static::make_entity($page);
    }

    return $pages;
  }

  public static function find_breadcrumbs_for_uri($uri, $params=array())
  {
    $pages = array();
    $uri = array_filter(preg_split('#/#', $uri));
    for ($index=1; $len=count($uri), $index<=$len; $index++) {
      $pages[] = static::find_by_uri(implode('/', array_slice($uri, 0, $index)), $params);
    }

    return $pages;
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
      ->select(array('p.*', 'pp.*', 'pu.*', 'pr.*', 'pr.id AS active_revision', 'pu.revision_id AS published_revision', 'pr.id AS revision_id', 'p.id'))
      ->join('pages AS p', 'p.id', '=', 'pr.page_id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->left_join('page_publishes AS pu', 'pu.page_id', '=', 'p.id')
      ->where('p.id', '=', $id)
      ->order_by('pr.updated_at', 'desc')
      ->get()
    ;

    $revisions = array();
    foreach ($query as $rev) {
      $revisions[] = static::make_entity($rev);
    }

    return $revisions;
  }

}