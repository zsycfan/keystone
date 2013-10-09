<?php

class ContentElementRevisionValue extends Eloquent {

  public function newCollection(array $models = array())
  {
    return new ContentElementRevisionValueCollection($models);
  }

}