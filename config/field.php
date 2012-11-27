<?php

$app = Config::get('application::keystone.field_directories') ?: array();

return array(
  'directories' => array_unique(array_merge($app, array(
    path('app').'fields',
    Bundle::path('keystone').'fields',
  )))
);