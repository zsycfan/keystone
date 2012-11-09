<?php

namespace Keystone\Repository;
use \DB;

class Page
{

  public static function create(\Keystone\Entity\Page &$page)
  {
    $page->id = \DB::table('pages')->insert_get_id(array(
      'created_at' => date('Y-m-d G:i:s'),
      'updated_at' => date('Y-m-d G:i:s'),
    ));

    $revision_id = \DB::table('page_revisions')->insert_get_id(array(
      'page_id' => $page->id,
      'language' => 'en-us',
      'layout' => $page->layout,
      'title' => null,
      'excerpt' => null,
      'regions' => null,
      'created_at' => date('Y-m-d G:i:s'),
      'updated_at' => date('Y-m-d G:i:s'),
    ));

    \DB::table('page_paths')->insert(array(
      'revision_id' => $revision_id,
    ));
  }

  public static function save(\Keystone\Entity\Page $page)
  {
    \DB::table('pages')
      ->where('id', '=', $page->id)
      ->update(array('updated_at' => date('Y-m-d G:i:s')))
    ;

    $revision_id = \DB::table('page_revisions')->insert_get_id(array(
      'page_id' => $page->get_raw('id'),
      'language' => $page->get_raw('language'),
      'layout' => $page->get_raw('layout'),
      'title' => $page->get_raw('title'),
      'excerpt' => $page->get_raw('excerpt'),
      'regions' => json_encode($page->get_raw('regions')),
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

    \DB::table('page_paths')->insert($path);
  }

  public static function revisions($id)
  {
    $revs = \DB::table('page_revisions')
      ->where('page_id', '=', $id)
      ->order_by('created_at', 'desc')
      ->get()
    ;

    $revisions = array();
    foreach ($revs as $rev) {
      $revisions[] = new \Keystone\Entity\PageRevision($rev);
    }

    return $revisions;
  }

  public static function create_entity($page)
  {
    // Decode our regions
    $page->regions = json_decode($page->regions, true);

    // Join our segment fields into an array
    $uri = array();
    foreach ($page as $key => $value) {
      if (preg_match('/^segment\d+$/', $key) && $value) {
        $uri[] = $value;
      }
    }

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

  public static function find($id, $params=array())
  {
    $page = \DB::table('pages AS p')
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
      return static::find($id, $params);
    }
    catch (Exception $e) {
      return new \Keystone\Entity\Page();
    }
  }

  public static function find_by_uri($uri, $params=array())
  {
    $page = \DB::table('pages AS p')
      ->select(array('*', 'p.id'))
      ->join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
      ->where('pp.uri', '=', $uri)
      ->order_by('pr.id', 'desc')
      ->take(1)
    ;

    if (@$params['published']) {
      $page->join('page_publishes AS pu', 'pu.page_id', '=', 'p.id');
      $page->where('pu.revision_id', '=', \DB::raw('`pr`.`id`'));
    }

    if (($page = $page->first()) == false) {
      throw new \Exception('Entity not found.');
    }

    return static::create_entity($page);
  }

}