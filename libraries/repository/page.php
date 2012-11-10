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
      'layout' => $page->layout,
      'title' => $page->title,
      'excerpt' => $page->excerpt,
      'regions' => json_encode($page->region)),
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

    // @todo check if the page is published, and if
    // so, update the page_publishes table.
  }

  public static function revisions($id)
  {
    $revs = DB::table('page_revisions')
      ->where('page_id', '=', $id)
      ->order_by('created_at', 'desc')
      ->get()
    ;

    $revisions = array();
    foreach ($revs as $rev) {
      $revisions[] = static::create_entity($rev);
    }

    return $revisions;
  }

  public static function create_entity($page)
  {
    // Decode our regions or set it to an empty array
    $page->regions = json_decode($page->regions, true);
    if (is_array($page->regions)) {
      foreach ($page->regions as &$region) {
        $region = new \Keystone\Region(array('fields' => $region));
      }
    }
    else {
      $page->regions = array();
    }

    // Join our segment fields into an array
    $uri = array();
    foreach ($page as $key => $value) {
      if (preg_match('/^segment\d+$/', $key) && $value) {
        $uri[] = $value;
      }
    }

    // Make our layout an object
    $page->layout = new \Keystone\Layout($page->layout, $page->regions);

    // Return the page entity
    $entity = new \Keystone\Entity\Page();
    $entity->id = $page->id;
    $entity->language = $page->language;
    $entity->layout = $page->layout;
    $entity->title = $page->title;
    $entity->excerpt = $page->excerpt;
    $entity->regions = $page->regions;
    $entity->uri = implode('/', $uri);
    return $entity;
  }

  public static function all()
  {
    $page_objects = DB::table('pages AS p')
      ->select(array('*', 'p.id'))
      ->left_join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->raw_where('`pr`.`id` = (SELECT MAX(`id`) FROM `page_revisions` AS `prc` WHERE `prc`.`page_id`=`p`.`id`)')
      ->left_join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->order_by('p.updated_at', 'desc')
      ->get()
    ;

    $pages = array();
    foreach ($page_objects as $object) {
      $page = new \Keystone\Entity\Page();
      $page->fill($object, true);
      $pages[] = $page;
    }

    return $pages;
  }

  public static function find($id, $params=array())
  {
    $page = DB::table('pages AS p')
      ->select(array('*', 'p.id'))
      ->where('p.id', '=', $id)
      ->join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->order_by('pr.id', 'desc')
      ->take(1)
      ->first()
    ;

    if (!$page) {
      throw new \Exception('Entity not found.');
    }

    return static::create_entity($page);
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

  public static function find_by_uri($uri, $params=array())
  {
    $page = DB::table('pages AS p')
      ->select(array('*', 'p.id'))
      ->join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->where('pp.uri', '=', $uri)
      ->order_by('pr.id', 'desc')
      ->take(1)
    ;

    if (@$params['published']) {
      $page->join('page_publishes AS pu', 'pu.page_id', '=', 'p.id');
      $page->where('pu.revision_id', '=', DB::raw('`pr`.`id`'));
    }

    if (($page = $page->first()) == false) {
      throw new \Exception('Entity not found.');
    }

    return static::create_entity($page);
  }

  public static function find_by_title($title, $params=array())
  {
    $page_objects = DB::table('pages AS p')
      ->select(array('*', 'p.id'))
      ->left_join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->raw_where('`pr`.`id` = (SELECT MAX(`id`) FROM `page_revisions` AS `prc` WHERE `prc`.`page_id`=`p`.`id`)')
      ->left_join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->order_by('p.updated_at', 'desc')
    ;

    $words = preg_split('/\s+/', $title);
    foreach ($words as $word) {
      $page_objects->where('pr.title', 'like', "%{$word}%");
    }

    $pages = array();
    foreach ($page_objects->get() as $object) {
      $page = new \Keystone\Entity\Page();
      $page->fill($object, true);
      $pages[] = $page;
    }

    return $pages;
  }

}