<?php

namespace Keystone;

class Region extends Object implements \Iterator
{

  public $name;
  public $as;
  public $max = null;
  public $min = null;
  public $fields = array();
  public $config = array();
  public $allow = array();
  private $index = 0;

  public function set_allow($value)
  {
    $this->allow = !is_array($value)?array($value):$value;
  }

  public function form()
  {
    return (string)\Laravel\View::make('keystone::region.edit')
      ->with('region', $this)
    ;
  }

  public function save()
  {
    $json = array();

    foreach ($this->fields as $index => $field) {
      $type = $field['type'];
      if (file_exists($path = path('fields').$type.'/field.php')) {
        require_once $path;
        $class = ucfirst($type).'_Field';
        if (class_exists($class)) {
          $obj = new $class;
          if (method_exists($obj, 'save')) {
            $json[$index] = $obj->save($this, $index, $field);
            continue;
          }
        }
      }
      $json[$index] = $field;
    }

    return $json;
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

    return trim(implode(' ', array_filter($summary)));
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
    $this->index = 0;
  }

  public function current()
  {
    $field = $this->fields[$this->index];
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
    return $this->index;
  }

  public function next()
  {
    ++$this->index;
  }

  public function valid()
  {
    return isset($this->fields[$this->index]);
  }

}
