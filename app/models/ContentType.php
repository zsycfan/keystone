<?php

class ContentType extends Eloquent {

  public function regionsForRow($i)
  {
  	return Region::where('content_type_id', '=', $this->id)
  	  ->where('row', '=', $i)
  	  ->orderBy('column_order', 'ASC')
  	  ->get()
  	;
  }

  public function content()
  {
  	return $this->hasOne('content');
  }

}