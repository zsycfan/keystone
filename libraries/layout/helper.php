<?php

function region($params) {
  $layout = \Keystone\Layout::active();
  $page = \Keystone\Entity\Page::active();
  return \Keystone\Region::make()
    ->with($params)
    ->with('fields', $page->regions->region($params['name']))
    ->form()
  ;

  // list($layout, $screen) = \Keystone\Layout::active();
  // $region = $layout->regions[$screen][$params['name']];
  // // $region->with('fields', $layout->region("{$screen}.{$params['name']}"));
  // foreach ($params as $k=>$v) {
  //   $region->$k = $v;
  // }
  // return $region->form();
}