<?php

namespace Keystone\Page;
use Keystone\Object;
use Keystone\Page;
use Laravel\Database as DB;

class Repository extends Object {

  public static function query($params=array())
  {
    $query = DB::table('pages AS p')
      ->select(array('p.*', 'pp.*', 'pu.*', 'pr.*', 'pr.id AS active_revision', 'pu.revision_id AS published_revision', 'pr.id AS revision_id', 'p.id'))
      ->join('page_revisions AS pr', 'pr.page_id', '=', 'p.id')
      ->left_join('page_paths AS pp', 'pp.revision_id', '=', 'pr.id')
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

  public static function findAll()
  {
    return Mapper::mapAllFromDatabase(static::query()->get());
  }

  public static function find($id)
  {
    return Mapper::mapFromDatabase(static::query()->where('p.id', '=', $id)->first());
  }

  public static function findOrCreate($id)
  {
    return static::find($id) ?: Page::make();
  }

  public static function save(Page $page)
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
      'language' => $page->language->countryCode,
      'layout' => $page->layout->name,
      //'regions' => $page->layout->regions,
      'title' => $page->title,
      'excerpt' => $page->excerpt,
      //'index' => $page->index,
      'created_at' => date('Y-m-d G:i:s'),
      'updated_at' => date('Y-m-d G:i:s'),
    ));

    // Add a row to the path table to track the URI of this revision
    if ($page->uri) {
      $path = array(
        'revision_id' => $revision_id,
        'uri' => $page->uri
      );
      foreach ($page->uri->segments as $index => $seg) {
        $index++;
        $path["segment{$index}"] = $seg;
      }
      DB::table('page_paths')->insert($path);
    }

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

}
