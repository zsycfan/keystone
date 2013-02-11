<?php

class Keystone_Content_Controller extends Keystone_Base_Controller {

  public function get_index()
  {
    return Redirect::to_route('content_'.Session::get('last_viewed_style', 'list'));
  }

  public function get_list()
  {
    Session::put('last_viewed_style', 'list');
    return Keystone\View::makeView('content/list')
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
    return Keystone\View::makeView('content/tree')
      ->with('pages', Keystone\Page\Repository::findAtUri(Input::get('uri')))
      ->with('tree', Keystone\Page\Repository::findBreadcrumbsForUri(Input::get('uri')))
    ;
  }

  public function get_new()
  {
    return Keystone\View::makeView('content/new')
      ->with('layouts', Keystone\FileManager::getLayoutDirectoryContents())
    ;
  }

  public function get_edit($id, $screen)
  {
    return Keystone\View::makeView('content/edit')
      ->with('page', Keystone\Page\Repository::find($id, array('revision' => Input::get('revision'))))
    ;
  }

  public function get_layout($id)
  {
    return Keystone\View::makeView('content/layout')
      ->with('layouts', Keystone\FileManager::getLayoutDirectoryContents())
      ->with('page', Keystone\Page\Repository::find($id))
    ;
  }

  public function get_content($id)
  {
    return Keystone\View::makeView('content/edit')
      ->with('page', Keystone\Page\Repository::find($id, array('revision' => Input::get('revision'))))
    ;
  }

  public function get_settings($id)
  {
    return Keystone\View::makeView('content/settings')
      ->with('page', Keystone\Page\Repository::find($id, array('revision' => Input::get('revision'))))
    ;
  }

  public function get_add_field($id, $screen, $region_name)
  {
    $page = Keystone\Page\Repository::find($id, array('revision' => Input::get('revision')));
    $region = $page->layout->getRegion($region_name);
    return Keystone\View::makeView('content/add_field')
      ->with('page', $page)
      ->with('screen', $screen)
      ->with('region', $region)
      ->with('allowedFields', $region->allow)
    ;
  }

  public function post_add_field($id, $screen, $region_name)
  {
    $page = Keystone\Page\Repository::find($id, array('revision' => Input::get('revision')));
    $page->layout->getRegion($region_name)->addField(Keystone\Field::makeWithType(Input::get('type')));
    Keystone\Page\Repository::save($page);

    return Redirect::to_route(Input::get('redirect'), $page->id)
      ->with('message', 'Field Added!')
      ->with('message_type', 'success')
    ;
  }

  public function get_revisions($id)
  {
    return Keystone\View::make('keystone::content.revisions')
      ->with('page', Keystone\Repository\Page::find($id, array('revision' => Input::get('revision'))))
      ->with('revisions', Keystone\Repository\Page::revisions($id))
    ;
  }

  public function post_save($id=false)
  {
    $page = Keystone\Page\Mapper::mapFromPost(Input::get('page'));
    Keystone\Page\Repository::save($page);
    return Redirect::to_route(Input::get('redirect'), $page->id)
      ->with('message', 'Page Saved!')
      ->with('message_type', 'success')
    ;
  }

}