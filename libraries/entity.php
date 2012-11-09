<?php

namespace Keystone;

class Entity
{

  protected $attributes = array();
  protected $accessible = array();

  public function __construct($data=array())
  {
    $this->fill($data);
  }

  public function __set($key, $value)
  {
    if (method_exists($this, $method="set_{$key}")) {
      call_user_func_array(array($this, $method), array($value));
    }
    else {
      $this->attributes[$key] = $value;
    }
  }

  public function __get($key)
  {
    if (method_exists($this, $method="get_{$key}")) {
      return call_user_func_array(array($this, $method), array());
    }
    else {
      return @$this->attributes[$key];
    }
  }

  public function __isset($key)
  {
    return isset($this->attributes[$key]);
  }

  public function fill($data, $raw=false)
  {
    foreach ($data as $key => $value) {
      if ($raw == false) {
        if (!empty($this->accessible) && !in_array($key, $this->accessible)) {
          throw new \Exception("You can&rsquo;t set [{$key}]");
        }
      }
      
      $this->attributes[$key] = $value;
    }

    return $this;
  }

  public function get_raw($key)
  {
    return @$this->attributes[$key];
  }

  public function to_array()
  {
    return $this->attributes;
  }

}