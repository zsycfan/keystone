<?php

Route::any('(:bundle)', function() { return Redirect::to_route('content'); });

Route::any('(:bundle)/dashboard', array('as' => 'dashboard', 'uses' => 'keystone::dashboard@index'));

Route::any('(:bundle)/content', array('as' => 'content', 'uses' => 'keystone::content@index'));
Route::any('(:bundle)/content/new', array('as' => 'content_new', 'uses' => 'keystone::content@new'));
Route::any('(:bundle)/content/(:num)' array('as' => 'content_save', 'uses' => 'keystone::content@save'));
Route::any('(:bundle)/content/(:num)/layout', array('as' => 'content_edit_layout', 'uses' => 'keystone::content@layout'));
Route::any('(:bundle)/content/(:num)/content', array('as' => 'content_edit_content', 'uses' => 'keystone::content@content'));
Route::any('(:bundle)/content/(:num)/settings', array('as' => 'content_edit_settings', 'uses' => 'keystone::content@settings'));
Route::any('(:bundle)/content/(:num)/revisions', array('as' => 'content_edit_revisions', 'uses' => 'keystone::content@revisions'));

Route::any('(:bundle)/assets/(:num)', array('as' => 'asset_view', 'uses' => 'keystone::assets@view'));
Route::any('(:bundle)/assets/upload', array('as' => 'asset_upload', 'uses' => 'keystone::assets@upload'));

Route::any('(:bundle)/api/pages/(:all)', array('as' => 'api_pages', 'uses' => 'keystone::api@pages'));

Route::any('(:bundle)(:all)', function($route) {
  if (file_exists($path = Bundle::path('keystone').'public'.$route)) {
    return Response::make(File::get($path), 200, array(
      'content-type' => File::mime(File::extension($path))
    ));
  }
  return Response::error('404');
});