<?php

namespace Keystone;

class Api extends Object
{
  protected $name;

  public static function makeWithName($name)
  {
    $obj = new static();
    $obj->name = $name;
    return $obj;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }
}