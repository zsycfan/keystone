<?php

class Keystone_Content_Controller extends Keystone_Base_Controller {

  public function get_index()
  {
    return Redirect::to_route('content_'.Session::get('last_viewed_style', 'list'));
  }

  public function get_list()
  {
    Session::put('last_viewed_style', 'list');
    return Troup\View::make('keystone::content.list')
      ->with('pages', Keystone\Page\Repository::findAll())
    ;
  }

  public function get_tree()
  {
    if (Input::query('uri') === null) {
      return Redirect::to(URL::to_route('content_tree').'?uri='.Session::get('last_viewed_uri'));
    }
    Session::put('last_viewed_style', 'tree');
    Session::put('last_viewed_uri', Input::get('uri'));
    return Keystone\View::make('keystone::content.tree')
      ->with('pages', Keystone\Repository\Page::find_at_uri(Input::get('uri')))
      ->with('tree', Keystone\Repository\Page::find_breadcrumbs_for_uri(Input::get('uri')))
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
      ->with('page', Keystone\Repository\Page::find($id, array('revision' => Input::get('revision'))))
    ;
  }

  public function get_content($id)
  {
    return Keystone\View::make('keystone::content.edit')
      ->with('page', Keystone\Repository\Page::find($id, array('revision' => Input::get('revision'))))
      ->with('fields', Keystone\Field::all())
      ->with('field_css', Keystone\Field::css())
      ->with('field_javascript', Keystone\Field::javascript())
      ->with('field_templates', Keystone\Field::templates())
    ;
  }

  public function get_settings($id)
  {
    return Keystone\View::make('keystone::content.settings')
      ->with('page', Keystone\Repository\Page::find($id, array('revision' => Input::get('revision'))))
      ->with('fields', Keystone\Field::all())
      ->with('field_css', Keystone\Field::css())
      ->with('field_javascript', Keystone\Field::javascript())
      ->with('field_templates', Keystone\Field::templates())
    ;
  }

  public function get_revisions($id)
  {
    return Keystone\View::make('keystone::content.revisions')
      ->with('page', Keystone\Repository\Page::find($id, array('revision' => Input::get('revision'))))
      ->with('revisions', Keystone\Repository\Page::revisions($id))
    ;
  }

  /**
   * @todo the page.uri check here is wrong. if a user tries to set the uri to
   * and empty string ("") the condition will fail
   * @todo  page.layout should really be page.layout.name
   * @todo  page.regions should really be page.regions
   */
  public function post_save($id=false)
  {
    $page = Keystone\Repository\Page::find_or_create($id);
    $page->published = Input::get('page.publish') === '1';

    if (Input::get('page.layout')) $page->layout->name = Input::get('page.layout');
    if (Input::get('page.regions')) $page->regions = Input::get('page.regions');
    if (Input::get('page.published_at')) $page->published_at = Input::get('page.published_at');
    if (Input::get('page.parent')) $page->set_uri_by_parent(Input::get('page.parent'));
    if (Input::get('page.uri')) $page->uri = Input::get('page.uri');
    
    Keystone\Repository\Page::save($page);

    return Redirect::to_route(Input::get('redirect'), $page->id)
      ->with('message', 'Saved!')
      ->with('message_type', 'success')
    ;
  }

}