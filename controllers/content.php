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
    $page = new Keystone\Entity\Page();
    $page->layout = Input::get('layout');
    \Keystone\Repository\Page::create($page);
    return Redirect::to_route('content_edit_content', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_layout($id)
  {
    $page = Keystone\Repository\Page::find($id);
    return Keystone\View::make('keystone::content.layout')
      ->with('layouts', Keystone\Layout::all())
      ->with('page', $page)
    ;
  }

  public function post_layout()
  {
    $page = Keystone\Repository\Page::find(Input::get('id'));
    $page->layout = Input::get('layout');
    Keystone\Repository\Page::save($page);
    return Redirect::to_route('content_edit_layout', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_content($id)
  {
    return Keystone\View::make('keystone::content.edit')
      ->with('page', Keystone\Repository\Page::find($id))
      ->with('fields', Keystone\Field::all())
      ->with('field_templates', Keystone\Field::handlebars_templates())
    ;
  }

  public function post_content()
  {
    $page = Keystone\Repository\Page::find(Input::get('id'));
    $page->regions = Input::get('regions');
    Keystone\Repository\Page::save($page);
    return Redirect::to_route('content_edit_content', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_settings($id)
  {
    $page = Keystone\Repository\Page::find($id);
    return Keystone\View::make('keystone::content.settings')
      ->with('page', $page)
    ;
  }

  public function post_settings()
  {
    $page = Keystone\Repository\Page::find(Input::get('id'));
    $page->uri = Input::get('uri');
    $page->published_at = Input::get('published_at');
    Keystone\Repository\Page::save($page);
    return Redirect::to_route('content_edit_settings', $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

  public function get_revisions($id)
  {
    $page = Keystone\Repository\Page::find($id);
    return Keystone\View::make('keystone::content.revisions')
      ->with('page', $page)
      ->with('revisions', Keystone\Repository\Page::revisions($id))
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