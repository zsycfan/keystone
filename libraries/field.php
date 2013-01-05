<?php

namespace Keystone;

class Field extends Object {

  private $type;
  private $data = array();

  public static function make()
  {
    throw new \Exception('Fields must be created with an explicit type. Try `Field::makeType(\'type\')` instead.');
  }

  public static function makeType($type)
  {
    $obj = new static();
    $obj->type = $type;
    return $obj;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function form()
  {
    return View::makeView('field/form')
      ->with('type', $this->type)
      ->with('data', $this->data)
      ->render()
    ;
  }
  
}