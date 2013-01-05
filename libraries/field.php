<?php

namespace Keystone;

class Field extends Object {

  private $type;
  private $data = array();

  public static function make()
  {
    throw new \Exception('Fields must be created with an explicit type. Try `Field::makeType(\'type\')` instead.');
  }

  public static function makeWithType($type)
  {
    $obj = new static();
    $obj->type = $type;
    return $obj;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function form($data=array())
  {
    $data = array_merge($this->data, $data);
    return View::make('keystone::field.form')
      ->with('type', $this->type)
      ->with('data', $data)
      ->render()
    ;
  }
  
}
