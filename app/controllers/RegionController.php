<?php

class RegionController extends BaseController {

  public function getAdd(ContentType $contentType, $row, Content $content=null)
  {
    return View::make('region/add')
    	->with('type', $contentType)
      ->with('content', $content)
    	->with('row', $row)
    ;
  }

  public function postAdd(ContentType $contentType, $row, Content $content=null)
  {
    $region = new Region;
    $region->name = Input::get('region.name');
    $region->slug = Input::get('region.slug');
    $region->content_type_id = $contentType->id;
    $region->row = $row;
    $region->column_width = Input::get('region.column_width');
    $region->column_offset = Input::get('region.column_offset');
    $region->column_order = Input::get('region.column_order');
    $region->save();

    if ($content) {
      return Redirect::route('editContent', $content->id);
    }

    return Redirect::route('listContentTypes');
  }

}