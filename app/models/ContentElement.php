<?php

class ContentElement extends Eloquent {

  public function content()
  {
  	return $this->belongsTo('Content');
  }

  public function element()
  {
    return $this->belongsTo('Element');
  }

  public function type()
  {
    return $this->belongsTo('Element', 'element_id');
  }

  public function revisions()
  {
    return $this->hasMany('ContentElementRevision');
  }

  public function revision($published=null)
  {
    $revisions = $this->revisions();
    if ($published != null) {
      $revisions = $revisions->where('published', $published);
    }
    return $revisions->orderby('id', 'desc')->first();
  }

  public function publishedRevision()
  {
    return $this->revision(true);
  }

  public function deservesRevision(array $values)
  {
    if (!$this->revision()) {
      return true;
    }

    foreach (Input::get('field', array()) as $fieldId => $fieldValue) {
      if ($this->revision()->getFieldId($fieldId)->value !== $fieldValue) {
        return true;
      }
    }

    return false;
  }

  public function createRevision(array $values)
  {
    if (!$this->deservesRevision($values)) {
      return $this->revision();
    }

    $revision = new ContentElementRevision;
    $revision->published = 0;
    $revision->lang = 'en';
    $this->revisions()->save($revision);
    
    foreach (Input::get('field', array()) as $fieldId => $fieldValue) {

      $value = new ContentElementRevisionValue;
      $value->field_id = $fieldId;
      $value->value = $fieldValue;
      $revision->values()->save($value);
    }

    return $revision;
  }

}