<?php

class ContentController extends BaseController {

  public function getIndex(ContentType $contentType=null)
  {
    if (@$contentType->single && $contentType->content) {
      return Redirect::route('editContent', $contentType->content->id);
    }
    else if(@$contentType->single) {
      return Redirect::route('addContent', $contentType->slug);
    }

    return View::make('content/index')
      ->with('entities', Content::where('content_type_id', $contentType->id)->get())
    ;
  }

  public function getAdd(ContentType $contentType)
  {
    $content = new Content;
    $content->content_type_id = $contentType->id;
    $content->save();

    return Redirect::route('editContent', $content->id);
  }

  public function getEdit(Content $content)
  {
    return View::make('content/add')
      ->with('type', $content->type)
      ->with('content', $content)
    ;
  }

  public function postEdit(Content $content)
  {
    foreach (Input::get('content.uri', array()) as $key => $uri) {
      if (!$uri) continue;

      $contentUri = new ContentUri;
      if (is_numeric($key)) {
        $contentUri = ContentUri::find($key);
      }

      $contentUri->uri = $uri;
      $content->uris()->save($contentUri);
    }

    return Redirect::route('editContent', $content->id);
  }

  public function getDeleteUri(ContentUri $uri)
  {
    $uri->delete();

    return Redirect::route('editContent', $uri->content->id);
  }

  public function postPublish(Content $content)
  {
    $content->published = 1;
    $content->save();

    return Redirect::route('editContent', $content->id);
  }

  public function postUnpublish(Content $content)
  {
    $content->published = 0;
    $content->save();

    return Redirect::route('editContent', $content->id);
  }

}