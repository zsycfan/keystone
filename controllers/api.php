<?php

class Keystone_Api_Controller extends Keystone_Base_Controller
{

  public $restful = false;

  public function action_pages($query)
  {
    $pages = Keystone\Repository\Page::find_by_title($query);
    foreach ($pages as &$page) {
      $page = $page->to_array();
    }
    return Response::make(json_encode($pages), 200, array(
      'Content-type' => 'application/json'
    ));
  }

  public function action_page($id)
  {
    $page = Keystone\Repository\Page::find($id);
    $page->order = Input::get('order');
    Keystone\Repository\Page::save($page);
    return Response::make(json_encode($page->to_array()), 200, array(
      'Content-type' => 'application/json'
    ));
  }

  public function action_custom($plugin, $method, $args='')
  {
    $class = ucfirst($plugin).'_Api';
    $action = strtolower(Request::method()).'_'.$method;
    $args = array_merge(array_filter(preg_split('#/#', $args)));

    require_once Bundle::path('keystone').'fields/'.$plugin.'/api.php';
    $obj = new $class;
    return call_user_func_array(array($obj, $action), $args);
  }
}