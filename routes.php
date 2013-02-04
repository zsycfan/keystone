<?php

Route::get('(:bundle)', function() { return Redirect::to_route('content_list'); });

Route::get('(:bundle)/dashboard', array('as' => 'dashboard', 'uses' => 'keystone::dashboard@index'));

Route::get('(:bundle)/content', array('as' => 'content', 'uses' => 'keystone::content@index'));
Route::get('(:bundle)/content/list', array('as' => 'content_list', 'uses' => 'keystone::content@list'));
Route::get('(:bundle)/content/tree', array('as' => 'content_tree', 'uses' => 'keystone::content@tree'));
Route::get('(:bundle)/content/new', array('as' => 'content_new', 'uses' => 'keystone::content@new'));
Route::post('(:bundle)/content/(:num?)', array('as' => 'content_save', 'uses' => 'keystone::content@save'));
Route::get('(:bundle)/content/(:num)/layout', array('as' => 'content_edit_layout', 'uses' => 'keystone::content@layout'));
Route::get('(:bundle)/content/(:num)/content', array('as' => 'content_edit_content', 'uses' => 'keystone::content@content'));
Route::get('(:bundle)/content/(:num)/settings', array('as' => 'content_edit_settings', 'uses' => 'keystone::content@settings'));
Route::get('(:bundle)/content/(:num)/revisions', array('as' => 'content_edit_revisions', 'uses' => 'keystone::content@revisions'));
Route::any('(:bundle)/content/(:num)/(:any)/add_field/(:any)', array('as' => 'content_add_field', 'uses' => 'keystone::content@add_field'));

Route::get('(:bundle)/field/css', array('as' => 'field_css', 'uses' => 'keystone::field@css'));
Route::get('(:bundle)/field/javascript', array('as' => 'field_javascript', 'uses' => 'keystone::field@javascript'));

Route::post('(:bundle)/assets', array('as' => 'asset_upload', 'uses' => 'keystone::assets@upload'));
Route::get('(:bundle)/assets/(:num)', array('as' => 'asset_show', 'uses' => 'keystone::assets@show'));

Route::get('(:bundle)/api/pages/(:all)', array('uses' => 'keystone::api@pages'));
Route::post('(:bundle)/api/page/(:num)', array('uses' => 'keystone::api@page'));
Route::any('(:bundle)/api/(:any)/(:any?)', array('uses' => 'keystone::api@custom'));

Route::get('(:bundle)(:all)', function($route) {
  if (file_exists($path = Bundle::path('keystone').'public'.$route)) {
    return Response::make(File::get($path), 200, array(
      'content-type' => File::mime(File::extension($path))
    ));
  }
  return Response::error('404');
});