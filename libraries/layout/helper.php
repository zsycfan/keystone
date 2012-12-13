<?php

function region($params) {
  list($layout, $screen) = \Keystone\Layout::active();
  return \Keystone\Region::make($params)
    ->with('fields', $layout->region("{$screen}.{$params['name']}"))
    ->with('tokens', $layout->region("{$screen}.{$params['name']}")->tokens)
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