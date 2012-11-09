<?php

class Keystone_Api_Controller extends Keystone_Base_Controller
{

  public function get_pages($query)
  {
    $pages = Keystone\Repository\Page::find_by_title($query);
    foreach ($pages as &$page) {
      $page = $page->to_array();
    }
    return Response::make(json_encode($pages), 200, array(
      'Content-type' => 'application/json'
    ));
  }

}