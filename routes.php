<?php

Route::get('(:bundle)', function() { return Redirect::to_route('content'); });

Route::get('(:bundle)/dashboard', array('as' => 'dashboard', 'uses' => 'keystone::dashboard@index'));

Route::get('(:bundle)/content', array('as' => 'content', 'uses' => 'keystone::content@index'));

Route::get('(:bundle)/content/new', array('as' => 'content_new', 'uses' => 'keystone::content@new'));
Route::post('(:bundle)/content/new', array('as' => 'content_save_new', 'uses' => 'keystone::content@new'));

Route::get('(:bundle)/content/(:num)/layout', array('as' => 'content_edit_layout', 'uses' => 'keystone::content@layout'));
Route::post('(:bundle)/content/layout', array('as' => 'content_save_layout', 'uses' => 'keystone::content@layout'));

Route::get('(:bundle)/content/(:num)/content', array('as' => 'content_edit_content', 'uses' => 'keystone::content@content'));
Route::post('(:bundle)/content/content', array('as' => 'content_save_content', 'uses' => 'keystone::content@content'));

Route::get('(:bundle)/content/(:num)/settings', array('as' => 'content_edit_settings', 'uses' => 'keystone::content@settings'));
Route::post('(:bundle)/content/settings', array('as' => 'content_save_settings', 'uses' => 'keystone::content@settings'));

Route::get('(:bundle)/content/(:num)/revisions', array('as' => 'content_edit_revisions', 'uses' => 'keystone::content@revisions'));
Route::post('(:bundle)/content/revisions', array('as' => 'content_save_revisions', 'uses' => 'keystone::content@revisions'));

Route::get('(:bundle)/fields/css', array('as' => 'field_css', 'uses' => 'keystone::fields@css'));
Route::get('(:bundle)/fields/js', array('as' => 'field_js', 'uses' => 'keystone::fields@js'));

Route::get('(:bundle)/assets/(:num)', array('as' => 'asset_view', 'uses' => 'keystone::assets@view'));
Route::post('(:bundle)/assets/upload', array('as' => 'asset_upload', 'uses' => 'keystone::assets@upload'));

Route::get('(:bundle)/api/pages/(:all)', array('as' => 'api_pages', 'uses' => 'keystone::api@pages'));

Route::get('(:bundle)(:all)', function($route) {
  if (file_exists($path = Bundle::path('keystone').'public'.$route)) {
    return Response::make(File::get($path), 200, array(
      'content-type' => File::mime(File::extension($path))
    ));
  }
  return Response::error('404');
});