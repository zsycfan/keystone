<?php

class ContentElementRevisionValueCollection extends \Illuminate\Database\Eloquent\Collection {

  public function where($key, $value=null)
  {
    return parent::filter(function($row) use ($key,$value) {
      return $row->{$key} == $value;
    });
  }

}