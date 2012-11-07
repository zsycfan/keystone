<?php

class Keystone_Content_Controller extends Keystone_Base_Controller {

  public function get_index()
  {
    return Keystone\View::make('keystone::content.list')
      ->with('layouts', Keystone\Layout::all())
      ->with('pages', Keystone\Page::all())
    ;
  }

  public function get_new()
  {
    return Keystone\View::make('keystone::content.new')
      ->with('layouts', Keystone\Layout::all())
    ;
  }

  public function post_new()
  {
    $data = array(
      'layout' => Input::get('layout'),
      'published' => false,
    );

    $page = Keystone\Page::create(array());
    $revision = new Keystone\PageRevision($data);
    $page->revisions()->insert($revision);

    return Redirect::to_route('content_edit_content', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ; 
  }

  public function get_layout($id)
  {
    $page = Keystone\Page::find($id);
    $revision = $page->revision_or_latest(Input::get('revision'));
    return Keystone\View::make('keystone::content.layout')
      ->with('layouts', Keystone\Layout::all())
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

    $page = Keystone\Page::find(Input::get('id'));
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
    $page = Keystone\Page::find($id);
    $revision = $page->revision_or_latest(Input::get('revision'));
    $latest_revision = $page->latest_revision();

    if ($revision->id != $latest_revision->id) {
      Session::flash('message', 'Not the latest.');
      Session::flash('message_type', 'warning');
    }

    return Keystone\View::make('keystone::content.edit')
      ->with('page', $page)
      ->with('revision', $revision)
      ->with('latest_revision', $latest_revision)
      ->with('layout', Keystone\Layout::make($revision->layout, $revision->regions))
      ->with('fields', Keystone\Field::all())
      ->with('field_templates', Keystone\Field::handlebars_templates())
    ;
  }

  public function post_content()
  {
    $data = array(
      'layout' => Input::get('layout'),
      'regions' => Input::get('regions'),
      'published' => Input::get('published'),
    );

    $page = Keystone\Page::find(Input::get('id'));
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
    $page = Keystone\Page::find($id);
    $revision = $page->revision_or_latest(Input::get('revision'));

    return Keystone\View::make('keystone::content.settings')
      ->with('page', $page)
      ->with('revision', $revision)
    ;
  }

  public function post_settings()
  {
    $data = array(
      'path' => Input::get('path')?:null,
      'slug' => Input::get('slug')?:null,
      'published_at' => Input::get('published_at')?:null,
      'published' => Input::get('published'),
    );

    $page = Keystone\Page::find(Input::get('id'));
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
    $page = Keystone\Page::find($id);
    $revisions = $page->revisions()->get();

    return Keystone\View::make('keystone::content.revisions')
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

    $page = Keystone\Page::find(Input::get('id'));
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