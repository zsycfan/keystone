<?php

Route::group(array('prefix' => 'admin'), function() {

  Route::get('/types', array(
    'uses' => 'ContentTypeController@getIndex',
    'as' => 'listContentTypes'
  ));

  Route::get('/types/add', array(
    'uses' => 'ContentTypeController@getAdd',
    'as' => 'addContentType'
  ));

  Route::post('/types/add', array(
    'uses' => 'ContentTypeController@postAdd',
    'as' => 'postContentType'
  ));

  Route::get('/type/edit/{type}', array(
    'uses' => 'ContentTypeController@getEdit',
    'as' => 'editContentType'
  ));

  Route::get('/type/add-row/{contentType}', array(
    'uses' => 'ContentTypeController@getAddRow',
    'as' => 'addRow'
  ));

/** ---- **/

  Route::get('/content/add/{contentType}', array(
    'uses' => 'ContentController@getAdd',
    'as' => 'addContent'
  ));

  Route::get('/content/list/{contentType}', array(
    'uses' => 'ContentController@getIndex',
    'as' => 'listContent'
  ));

  Route::get('/content/edit/{content}', array(
    'uses' => 'ContentController@getEdit',
    'as' => 'editContent'
  ));

  Route::post('/content/edit/{content}', array(
    'uses' => 'ContentController@postEdit',
    'as' => 'postContent'
  ));

  Route::get('/uri/delete/{contentUri}', array(
    'uses' => 'ContentController@getDeleteUri',
    'as' => 'deleteContentUri',
  ));

  Route::post('/content/publish/{content}', array(
    'uses' => 'ContentController@postPublish',
    'as' => 'publishContent'
  ));

  Route::post('/content/unpublish/{content}', array(
    'uses' => 'ContentController@postUnpublish',
    'as' => 'unpublishContent'
  ));

/** ---- **/

  Route::get('/region/add/{contentType}/{row}/{content?}', array(
    'uses' => 'RegionController@getAdd',
    'as' => 'addRegion'
  ));

  Route::post('/region/add/{contentType}/{row}/{content?}', array(
    'uses' => 'RegionController@postAdd',
    'as' => 'postRegion'
  ));

/** ---- **/

  Route::get('/elements', array(
    'uses' => 'ElementController@getIndex',
    'as' => 'listElements'
  ));

  Route::get('/elements/new', array(
    'uses' => 'ElementController@getNew',
    'as' => 'newElement'
  ));

  Route::post('/elements/new', array(
    'uses' => 'ElementController@postNew',
    'as' => 'postNewElement'
  ));

  Route::get('/elements/edit/{element}', array(
    'uses' => 'ElementController@getEdit',
    'as' => 'editElement'
  ));

  Route::post('/elements/edit/{element}', array(
    'uses' => 'ElementController@postEdit',
    'as' => 'postEditElement'
  ));

  Route::get('/elements/edit/{element}/remove-field/{elementField}', array(
    'uses' => 'ElementController@getRemoveElementField',
    'as' => 'removeField'
  ));

  Route::get('/elements/add', array(
    'uses' => 'ElementController@getAdd',
    'as' => 'addElement'
  ));

  Route::post('/elements/add', array(
    'uses' => 'ElementController@postAdd',
    'as' => 'postElement'
  ));

/** ---- **/

  Route::get('/element/add/{content}/{region}', array(
    'uses' => 'ElementController@getAdd',
    'as' => 'addElement'
  ));

  Route::post('/element/add/{content}/{region}', array(
    'uses' => 'ElementController@postAdd',
    'as' => 'postElement'
  ));

  Route::get('/element/configure/{contentElement}', array(
    'uses' => 'ElementController@getConfigure',
    'as' => 'configureElement'
  ));

  Route::post('/element/configure/{contentElement}', array(
    'uses' => 'ElementController@postConfigure',
    'as' => 'postConfigureElement'
  ));

  Route::get('/element/publish/{revision}', array(
    'uses' => 'ElementController@getPublishElement',
    'as' => 'publishElement'
  ));

});

Route::bind('contentType', function($value, $route)
{
  return ContentType::where('slug', $value)->first();
});

Route::bind('region', function($value, $route)
{
  return Region::where('slug', $value)->first();
});

Route::bind('content', function($value, $route)
{
  return Content::find($value);
});

Route::bind('element', function($value, $route)
{
  return Element::find($value);
});

Route::bind('revision', function($value, $route)
{
  return ContentElementRevision::find($value);
});

Route::bind('contentElement', function($value, $route)
{
  return ContentElement::find($value);
});

Route::bind('elementField', function($value, $route)
{
  return ElementField::find($value);
});

Route::bind('contentUri', function($value, $route)
{
  return ContentUri::find($value);
});