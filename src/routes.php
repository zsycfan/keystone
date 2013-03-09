<?php

Route::group(array('prefix' => Config::get('keystone::keystone.admin_directory')), function()
{


  Route::get('/', ['as' => 'dashboard', function()
  {
    return 'dashboard';
  }]);


  Route::get('asset/{route}', ['as' => 'asset', function($route)
  {
    // $file = new Symfony\Component\HttpFoundation\File\File($path = keystonePath('public/'.$route));
    // die($file->getMimeType());

    if (file_exists($path = keystonePath('public/'.$route))) {
      return Response::make(File::get($path), 200, array(
        // 'content-type' => File::mime(File::extension($path))
      ));
    }
    return Response::error('404');
  }])
    ->where('route', '(.*)')
  ;


  Route::get('content/list', ['as' => 'content_list', function()
  {
    $path = Input::get('path');
    if ($path) $path = str_finish($path, '/');

    return View::make('keystone::content/list')
      ->with('pages', App::make('db')->pages->find(['path' => new MongoRegex('/^'.$path.'[^/]+$/')]));
    ;
  }]);


  Route::get('content/new', ['as' => 'content_new', function()
  {
    return View::make('keystone::content/new');
  }]);


  Route::post('content/new', function()
  {
    $node = Input::get('node');
    $node['path'] = Input::get('pathPrefix').$node['path'];
    App::make('db')->pages->insert($node);
    return Redirect::to('keystone/content/edit/'.$node['_id']);
  });


  Route::get('content/edit/{id}', ['as' => 'content_edit', function($id)
  {
    return App::make('twig')->loadTemplate('content/edit.twig')->render([
      'page' => App::make('db')->pages->findOne(['_id' => new MongoId($id)])
    ]);
  }]);


  Route::post('content/edit/{id}', function($id)
  {
    $id = new MongoId($id);
    $node = Input::get('node');
    App::make('db')->pages->update(['_id' => $id], $node);

    if (Request::ajax()) {
      return Response::json($node);
    }
    else {
      return Redirect::to('keystone/content/edit/'.$id);
    }
  });


});