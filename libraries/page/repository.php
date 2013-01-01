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

  public static function findAll()
  {
    return Mapper::mapAll(static::query()->get());
  }

  public static function find($id)
  {
    return Mapper::map(static::query()->where('p.id', '=', $id)->first());
  }

}
