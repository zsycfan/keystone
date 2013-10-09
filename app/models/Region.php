<?php

class Region extends Eloquent {

  public function cssClasses()
  {
  	return 'col-md-'.$this->column_width.($this->column_offset?' col-md-offset-'.$this->column_offset:'');
  }

}