<?php

Route::get('(:bundle)', function() { return Redirect::to_route('dashboard'); });

Route::get( '(:bundle)/dashboard',                              array('as' => 'dashboard',              'uses' => 'keystone::dashboard@index'));

Route::get( '(:bundle)/content',                                array('as' => 'content',                'uses' => 'keystone::content@index'));
Route::get( '(:bundle)/content/list',                           array('as' => 'content_list',           'uses' => 'keystone::content@list'));
Route::get( '(:bundle)/content/tree',                           array('as' => 'content_tree',           'uses' => 'keystone::content@tree'));
Route::get( '(:bundle)/content/new',                            array('as' => 'content_new',            'uses' => 'keystone::content@new'));
Route::get( '(:bundle)/content/(:num)/(:any)/add_field/(:any)', array('as' => 'content_add_field',      'uses' => 'keystone::content@add_field'));
Route::get( '(:bundle)/content/(:num)/(:any)',                  array('as' => 'content_edit',           'uses' => 'keystone::content@edit'));
Route::post('(:bundle)/content/(:num?)',                        array('as' => 'content_save',           'uses' => 'keystone::content@save'));

Route::get( '(:bundle)/field/css',                              array('as' => 'field_css',              'uses' => 'keystone::field@css'));
Route::get( '(:bundle)/field/javascript',                       array('as' => 'field_javascript',       'uses' => 'keystone::field@javascript'));

Route::post('(:bundle)/assets',                                 array('as' => 'asset_upload',           'uses' => 'keystone::assets@upload'));
Route::get( '(:bundle)/assets/(:num)',                          array('as' => 'asset_show',             'uses' => 'keystone::assets@show'));

Route::get( '(:bundle)/api/pages/(:all)',                       array('as' => 'api_pages',              'uses' => 'keystone::api@pages'));
Route::post('(:bundle)/api/page/(:num)',                        array('as' => 'api_page',               'uses' => 'keystone::api@page'));
Route::any( '(:bundle)/api/(:any)/(:any?)',                     array('as' => 'api_third_party',        'uses' => 'keystone::api@custom'));

Route::get('(:bundle)(:all)', function($route) {
  if (file_exists($path = Bundle::path('keystone').'public'.$route)) {
    return Response::make(File::get($path), 200, array(
      'content-type' => File::mime(File::extension($path))
    ));
  }
  return Response::error('404');
});