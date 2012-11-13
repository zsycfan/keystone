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
      $pages[] = \Keystone\Entity\Page::make()
        ->fill_and_translate($object, true)
      ;
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

    return \Keystone\Entity\Page::make()
      ->fill_and_translate($page, true)
    ;
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

    return \Keystone\Entity\Page::make()
      ->fill_and_translate($page, true)
    ;
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
    foreach ($page_objects->get() as $page) {
      $pages[] = \Keystone\Entity\Page::make()
        ->fill_and_translate($page, true)
      ;
    }

    return $pages;
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
      $revisions[] = \Keystone\Entity\Page::make()
        ->fill_and_translate($rev, true)
      ;
    }

    return $revisions;
  }

}