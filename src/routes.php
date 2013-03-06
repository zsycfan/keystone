<?php

Route::group(array('prefix' => Config::get('keystone::keystone.admin_directory')), function()
{

  Route::get('/', function()
  {
    return 'dashboard';
  });

  Route::get('/content', function($id=null)
  {
    return 'content';
  });

  Route::get('/content/new', function()
  {
    return View::make('keystone::content/new');
  });

  Route::post('/content/new', function()
  {
    $m = new MongoClient("mongodb://localhost");
    $m->keystone->pages->insert(array('date' => date('r')));
  });

});