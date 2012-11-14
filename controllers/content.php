<?php

class Keystone_Content_Controller extends Keystone_Base_Controller {

  public function get_index()
  {
    return Keystone\View::make('keystone::content.list')
      ->with('layouts', Keystone\Layout::all())
      ->with('pages', Keystone\Repository\Page::all())
    ;
  }

  public function get_new()
  {
    return Keystone\View::make('keystone::content.new')
      ->with('layouts', Keystone\Layout::all())
    ;
  }

  public function get_layout($id)
  {
    return Keystone\View::make('keystone::content.layout')
      ->with('layouts', Keystone\Layout::all())
      ->with('page', Keystone\Repository\Page::find($id))
    ;
  }

  public function get_content($id)
  {
    return Keystone\View::make('keystone::content.edit')
      ->with('page', Keystone\Repository\Page::find($id))
      ->with('fields', Keystone\Field::all())
      ->with('field_css', Keystone\Field::css())
      ->with('field_javascript', Keystone\Field::javascript())
      ->with('field_templates', Keystone\Field::templates())
    ;
  }

  public function get_settings($id)
  {
    return Keystone\View::make('keystone::content.settings')
      ->with('page', Keystone\Repository\Page::find($id))
    ;
  }

  public function get_revisions($id)
  {
    return Keystone\View::make('keystone::content.revisions')
      ->with('page', Keystone\Repository\Page::find($id))
      ->with('revisions', Keystone\Repository\Page::revisions($id))
    ;
  }

  public function post_save($id=false)
  {
    $page = Keystone\Repository\Page::find_or_create($id);
    $page->published = Input::get('page.published') == 1;
    if (Input::get('page.regions')) $page->regions = new Keystone\Regions(Input::get('page.regions'));
    if (Input::get('page.layout')) $page->layout = new Keystone\Layout(Input::get('page.layout'), $page);
    if (Input::get('page.published_at')) $page->published_at = Input::get('page.published_at');
    if (Input::get('page.uri')) $page->uri = Input::get('page.uri');
    Keystone\Repository\Page::save($page);

    return Redirect::to_route(Input::get('redirect'), $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

}