<?php

class ContentElementCollection extends Illuminate\Database\Eloquent\Collection {

  public function __toString()
  {
    return $this->first()->publishedRevision()->values()->first()->value;
  }

}