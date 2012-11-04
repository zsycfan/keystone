<?php

class Content_Controller extends Base_Controller {

  public function get_index()
  {
    return View::make('content.list')
      ->with('layouts', Layout::all())
      ->with('pages', Page::all())
    ;
  }

  public function get_new()
  {
    $page = new Page();
    $revision = new PageRevision();
    $page->revisions()->insert($revision);
    return View::make('content.new')
      ->with('layouts', Layout::all())
      ->with('page', $page)
      ->with('revision', $revision)
    ;
  }

  public function post_new()
  {
    $data = array(
      'layout' => Input::get('layout'),
      'published' => false,
    );

    $page = Page::create(array());
    $revision = new PageRevision($data);
    $page->revisions()->insert($revision);

    return Redirect::to_route('content_edit_content', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ; 
  }

  public function get_layout($id)
  {
    $page = Page::find($id);
    $revision = $page->revision_or_latest(Input::get('revision'));
    return View::make('content.layout')
      ->with('layouts', Layout::all())
      ->with('page', $page)
      ->with('revision', $revision)
    ;
  }

  public function post_layout()
  {
    $data = array(
      'layout' => Input::get('layout'),
      'published' => Input::get('published'),
    );

    $page = Page::find(Input::get('id'));
    $revision = $page->latest_revision()->fill($data);
    
    if ($revision->dirty()) {
      $page->touch();
      $page->revisions()->insert($revision->duplicate());
    }

    return Redirect::to_route('content_edit_layout', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_content($id)
  {
    $page = Page::find($id);
    $revision = $page->revision_or_latest(Input::get('revision'));
    $latest_revision = $page->latest_revision();

    if ($revision->id != $latest_revision->id) {
      Session::flash('message', 'Not the latest.');
      Session::flash('message_type', 'warning');
    }

    return View::make('content.edit')
      ->with('page', $page)
      ->with('revision', $revision)
      ->with('latest_revision', $latest_revision)
      ->with('layout', Layout::make($revision->layout, $revision->regions))
      ->with('fields', Field::all())
      ->with('field_templates', Field::handlebars_templates())
    ;
  }

  public function post_content()
  {
    $data = array(
      'layout' => Input::get('layout'),
      'regions' => Input::get('regions'),
      'published' => Input::get('published'),
    );

    $page = Page::find(Input::get('id'));
    $revision = $page->latest_revision()->fill($data);
    
    if ($revision->dirty()) {
      $page->touch();
      $page->revisions()->insert($revision->duplicate());
    }

    return Redirect::to_route('content_edit_content', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_settings($id)
  {
    $page = Page::find($id);
    $revision = $page->revision_or_latest(Input::get('revision'));

    return View::make('content.settings')
      ->with('page', $page)
      ->with('revision', $revision)
    ;
  }

  public function post_settings()
  {
    $data = array(
      'slug' => Input::get('slug')?:null,
      'published_at' => Input::get('published_at')?:null,
      'published' => Input::get('published'),
    );

    $page = Page::find(Input::get('id'));
    $revision = $page->latest_revision()->fill($data);
    
    if ($revision->dirty()) {
      $page->touch();
      $page->revisions()->insert($revision->duplicate());
    }

    return Redirect::to_route('content_edit_settings', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_revisions($id)
  {
    $page = Page::find($id);
    $revisions = $page->revisions()->get();

    return View::make('content.revisions')
      ->with('page', $page)
      ->with('revision', $page->revision_or_latest(Input::get('revision')))
      ->with('revisions', $revisions)
    ;
  }

  public function post_revisions()
  {
    $data = array(
      'published' => Input::get('published'),
    );

    $page = Page::find(Input::get('id'));
    $revision = $page->latest_revision()->fill($data);
    
    if ($revision->dirty()) {
      $page->touch();
      $page->revisions()->insert($revision->duplicate());
    }

    return Redirect::to_route('content_edit_revisions', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

}