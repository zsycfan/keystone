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

  public function post_page($id)
  {
    $page = Keystone\Repository\Page::find($id);
    $page->order = Input::get('order');
    Keystone\Repository\Page::save($page);
    return Response::make(json_encode($page->to_array()), 200, array(
      'Content-type' => 'application/json'
    ));
  }

  public function get_tags($query=null)
  {
    $tags = array(
      array('id' => 1, 'name' => 'test'),
      array('id' => 2, 'name' => 'two'),
      array('id' => 3, 'name' => 'another'),
      array('id' => 4, 'name' => 'blah'),
      array('id' => 5, 'name' => date('r')),
    );
    shuffle($tags);
    return json_encode($tags);
  }
  
  public function post_tag($tag)
  {
    
  }

}