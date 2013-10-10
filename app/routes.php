<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

include app_path().'/routes/admin.php';

Route::get('{uri}', function(Uri $uri) {
  $contentUri = ContentUri::with(array('content' => function($query) {
    return $query->where('published', '=', true);
  }))->where('uri', '=', $uri->string())->first();
  if (!$contentUri || !$contentUri->content) {
      App::abort(404);
  }
  $content = $contentUri->content;
  $type = $content->type;
  return View::make("types/{$type->slug}")
    ->with('page', $content);

  // $content = KEYContentModel::getByUri($uri);
  // var_dump($content->tagline);
  // die;

  // return View::make("types/{$content->type->slug}")
  //   ->with('page', $content);
})->where('uri', '.*');

Route::bind('uri', function($value, $route)
{
  return new Uri($value);
});