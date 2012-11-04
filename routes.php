<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', function() { return Redirect::to('content'); });

Route::get('dashboard', array('as' => 'dashboard', 'uses' => 'dashboard@index'));

Route::get('content', array('as' => 'content', 'uses' => 'content@index'));

Route::get('content/new', array('as' => 'content_new', 'uses' => 'content@new'));
Route::post('content/new', array('as' => 'content_save_new', 'uses' => 'content@new'));

Route::get('content/(:num)/layout', array('as' => 'content_edit_layout', 'uses' => 'content@layout'));
Route::post('content/layout', array('as' => 'content_save_layout', 'uses' => 'content@layout'));

Route::get('content/(:num)/content', array('as' => 'content_edit_content', 'uses' => 'content@content'));
Route::post('content/content', array('as' => 'content_save_content', 'uses' => 'content@content'));

Route::get('content/(:num)/settings', array('as' => 'content_edit_settings', 'uses' => 'content@settings'));
Route::post('content/settings', array('as' => 'content_save_settings', 'uses' => 'content@settings'));

Route::get('content/(:num)/revisions', array('as' => 'content_edit_revisions', 'uses' => 'content@revisions'));
Route::post('content/revisions', array('as' => 'content_save_revisions', 'uses' => 'content@revisions'));

Route::get('fields/css', array('as' => 'field_css', 'uses' => 'fields@css'));
Route::get('fields/js', array('as' => 'field_js', 'uses' => 'fields@js'));

Route::get('assets/(:num)', array('as' => 'asset_view', 'uses' => 'assets@view'));
Route::post('assets/upload', array('as' => 'asset_upload', 'uses' => 'assets@upload'));

Route::get('api/pages/(:all)', array('as' => 'api_pages', 'uses' => 'api@pages'));

// Route::controller(Controller::detect());

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});