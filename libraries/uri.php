<?php

namespace Keystone;

class Uri extends Object
{

  private $segments = array();

  public static function makeFromString($uri)
  {
    $obj = new static;
    $obj->segments = array_merge(array_filter(preg_split('/\//', $uri)));
    return $obj;
  }

  public function getSegments()
  {
    return $this->segments;
  }

  public function __toString()
  {
    return implode('/', $this->segments);
  }

}