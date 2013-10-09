<?php

class ContentTypeController extends BaseController {

	public function getIndex()
  {
    return View::make('type/index')
      ->with('types', ContentType::all())
    ;
  }

  public function getAdd()
  {
  	return View::make('type/add')
  	;
  }

  public function postAdd()
  {
  	$contentType = new ContentType;
    $contentType->name = Input::get('type.name');
  	$contentType->slug = Input::get('type.slug');
    $contentType->single = Input::get('type.single');
  	$contentType->save();

  	return Redirect::route('listContentTypes');
  }

  public function getAddRow($contentType)
  {
    $contentType->rows++;
    $contentType->save();
    return Redirect::route('');
  }

}