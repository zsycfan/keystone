<?php

$app = Config::get('application::keystone.layout_directories') ?: array();

return array(
  'directories' => array_merge($app, array(
    path('app').'layouts',
    Bundle::path('keystone').'layouts',
  ))
);