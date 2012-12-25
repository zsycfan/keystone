<?php

namespace Keystone;

class Region implements \Iterator
{

  public $name;
  public $as;
  public $max = null;
  public $min = null;
  private $position = 0;
  public $fields = array();
  public $config = array();
  public $allow = array();
  public $tokens = array();

  public static function make($params=array())
  {
    return new static($params);
  }

  public function __construct($params=array())
  {
    foreach ($params as $key => $value) {
      $this->with($key, $value);
    }
  }

  public function with($key, $value)
  {
    if (substr($key, 0, 6) == 'config' && strpos($key, ':')) {
      list($config, $field_type, $option) = explode(':', $key);
      $this->config[$field_type][$option] = $value;
    }
    else if ($key == 'allow' && !is_array($value)) {
      $this->$key = array($value);
    }
    else if ($key == 'fields') {
      foreach ($value as $index => $field) {
        if (file_exists($path = path('fields').$field['type'].'/field.php')) {
          require_once $path;
          $class = ucfirst($field['type']).'_Field';
          if (class_exists($class)) {
            $obj = new $class;
            if (method_exists($obj, 'summary')) {
              $field = $obj->save($this, $index, $field);
            }
          }
        }
      }
      $this->$key = $value;
    }
    else {
      $this->$key = $value;
    }

    return $this;
  }

  public function form()
  {
    return (string)\Laravel\View::make('keystone::region.edit')
      ->with('region', $this)
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
