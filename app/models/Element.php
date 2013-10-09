<?php

class Element extends Eloquent {

  public function fields()
  {
  	return $this->hasMany('ElementField');
  }

}