<?php

namespace Keystone;

class Region implements \Iterator
{

  public $name;
  public $max = null;
  public $min = null;
  private $position = 0;
  private $fields = array();

  public function __construct($params=array())
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

  public function summary()
  {
    $summary = array();
    foreach ($this->fields as $field) {
      $type = $field['type'];
      if (file_exists($path = path('fields').$type.'/field.php')) {
        require_once $path;
        $class = ucfirst($type).'_Field';
        if (class_exists($class)) {
          $obj = new $class;
          if (method_exists($obj, 'summary')) {
            $summary[] = $obj->summary($field);
            continue;
          }
        }
      }
      $summary[] = @$field['content'];
    }

    if (!array_filter($summary)) {
      $summary[] = 'Untitled';
    }

    return implode(' ', $summary);
  }

  public function to_array()
  {
    return $this->fields;
  }

  public function json()
  {
    return json_encode($this->to_array());
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