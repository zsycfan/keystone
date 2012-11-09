<?php

namespace Keystone;

class Region implements \Iterator
{

  public $name;
  public $max = null;
  public $min = null;
  private $position = 0;
  private $fields;

  public function __construct($params)
  {
    foreach ($params as $key => $value) {
      $this->$key = $value;
    }
  }

  public function form()
  {
    return (string)\Laravel\View::make('keystone::region.edit')
      ->with('region', $this)
      ->with('data', $this->fields)
    ;
  }

  public function rewind()
  {
    $this->position = 0;
  }

  public function current()
  {
    $field = $this->fields[$this->position];
    $type = $field['type'];
    if (file_exists($path = path('fields').$type.'/field.php')) {
      require_once $path;
      $class = ucfirst($type).'_Field';
      if (class_exists($class)) {
        $obj = new $class;
        if (method_exists($obj, 'get')) {
          $field = $obj->get($field);
        }
      }
    }
    return $field;
  }

  public function key()
  {
    return $this->position;
  }

  public function next()
  {
    ++$this->position;
  }

  public function valid()
  {
    return isset($this->fields[$this->position]);
  }

}