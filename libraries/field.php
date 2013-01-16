<?php

namespace Keystone;

class Field extends Object {

  private $type;
  private $data = array();
  private static $directories = array();

  public static function addDirectory($dir)
  {
    static::$directories[] = str_finish($dir, '/');
  }

  public static function getAll()
  {
    $return = array();
    $dirs = static::$directories;
    foreach ($dirs as $dir) {
      if (is_dir($dir)) {
        $fields = scandir($dir);
        foreach ($fields as $field) {
          if (substr($field, 0, 1) == '.') continue;
          $return[] = $field;
        }
      }
    }

    return $return;
  }

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
  
  public function getType()
  {
    return $this->type;
  }

  public function setData($data)
  {
    $this->data = $data;
    return $this;
  }
  
  public function addData($key, $value=null)
  {
    $this->data[$key] = $value;
    return $this;
  }

  public function getData()
  {
    return $this->data;
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
      ->with('form', View::makeField('plain/form')->render())
      ->render()
    ;
  }
  
}
