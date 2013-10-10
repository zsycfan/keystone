<?php

class ElementField extends Eloquent {

  public function revisionValue()
  {
    return $this->hasMany('ContentElementRevisionValue', 'field_id');
  }

}