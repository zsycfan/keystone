<?php

Route::group(array('prefix' => Config::get('keystone::keystone.admin_directory')), function()
{

  Route::get('/', function()
  {
    return 'dashboard';
  });

  Route::get('/content', function()
  {
    return 'content';
  });

});