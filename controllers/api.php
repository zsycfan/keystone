<?php

class Api_Controller extends Base_Controller
{

  public function get_pages($query)
  {
    $queries = preg_split('/\s+/', $query);
    $q = PageRevision::group_by('page_id');

    foreach ($queries as $query) {
      $q->where('title', 'like', "%{$query}%");
    }

    return Response::eloquent($q->get());
  }

}