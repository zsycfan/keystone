<?php

namespace Keystone;

class Field extends Object {

  private $type;
  private $data = array();

  public static function make()
  {
    throw new \Exception('Fields must be created with an explicit type. Try `Field::makeWithType(\'plain\')` instead.');
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
  
  public function addData($key, $value=null)
  {
    $this->data[$key] = $value;
  }

  public function getSummary()
  {
    return @$this->data['content'];
  }

  public function renderForm()
  {
    return View::makeView('field/form')
      ->with('type', $this->type)
      ->with('data', $this->data)
      ->render()
    ;
  }
  
}
