<?php

class ContentElementRevision extends Eloquent {

  public function element()
  {
  	return $this->belongsTo('ContentElement', 'content_element_id');
  }

  public function values()
  {
    return $this->hasMany('ContentElementRevisionValue', 'revision_id')
      ->join('element_fields', 'element_fields.id', '=', 'content_element_revision_values.field_id')
    ;
  }

  public function getFieldId($fieldId)
  {
  	return $this->values()->where('field_id', '=', $fieldId)->first();
  }

  public function getFieldName($fieldName)
  {
    return $this->values()->where('slug', '=', $fieldName)->first();
  }

}