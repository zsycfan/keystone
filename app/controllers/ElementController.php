<?php

class ElementController extends BaseController {

  public function getIndex()
  {
    return View::make('element/index')
      ->with('elements', Element::all())
    ; 
  }

  public function getNew()
  {
    return View::make('element/new');
  }

  public function postNew()
  {
    $element = new Element;
    $element->name = Input::get('element.name');
    $element->slug = Input::get('element.slug');
    $element->save();
    return Redirect::route('listElements');
  }

  public function getEdit(Element $element)
  {
    return View::make('element/edit')
      ->with('element', $element)
    ;
  }

  public function postEdit(Element $element)
  {
    if (Input::get('newField')) {
      $elementField = new ElementField;
      $elementField->element_id = $element->id;
      $elementField->name = Input::get('newField.name');
      $elementField->slug = Input::get('newField.slug');
      $elementField->type = Input::get('newField.type');
      $elementField->save();
    }

    return Redirect::route('editElement', $element->id)
      ->with('successMessage', 'Field added')
    ;
  }

  public function getRemoveElementField(Element $element, ElementField $field)
  {
    $field->delete();
    return Redirect::route('editElement', $element->id);
  }

  public function getAdd(Content $content, Region $region)
  {
  	return View::make('element/add')
  	  ->with('content', $content)
  	  ->with('region', $region)
      ->with('elements', Element::all())
  	;
  }

  public function postAdd(Content $content, Region $region)
  {
    $contentElement = new ContentElement;
    $contentElement->content_id = $content->id;
    $contentElement->region_id = $region->id;
    $contentElement->element_id = Input::get('element.id');
    $contentElement->element_order = 0;
    $contentElement->save();

  	return Redirect::route('configureElement', $contentElement->id);
  }

  public function getConfigure(ContentElement $element)
  {
    return View::make('element/configure')
      ->with('element', $element)
    ;
  }

  public function postConfigure(ContentElement $element)
  {
    $element->createRevision(Input::get('field', array()));
    return Redirect::route('editContent', $element->content->id);
  }

  public function getPublishElement(ContentElementRevision $revision)
  {
    ContentElementRevision::where('content_element_id', '=', $revision->element->id)
      ->update(array('published' => 0));

    $revision->published = true;
    $revision->save();

    return Redirect::route('editContent', $revision->element->content->id);
  }

}