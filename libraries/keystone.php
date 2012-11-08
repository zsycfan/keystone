<?php

namespace Keystone;

class Keystone
{

  /**
   * Creates a new API instance using the passed params
   * 
   * @param  array $params
   * @return array
   */
  public static function make($params)
  {
    $obj = new static();
    foreach ($params as $key => $value) {
      $obj->$key = $value;
    }
    return $obj;
  }

  /**
   * Get pages matching the params
   * 
   * @param  array $params
   * @return [type]         [description]
   */
  public function get_pages()
  {
    $page = \Keystone\PageRevision::where('language', '=', 'en-us')
      ->join('page_paths', 'page_paths.revision_id', '=', 'page_revisions.id')
      ->where(\DB::raw('concat_ws("/", page_paths.segment_1, page_paths.segment_2)'), '=', $this->uri)
      ->first()
    ;
    return $page;
  }

}