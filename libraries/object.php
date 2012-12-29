<?php

namespace Keystone;

class Object
{
  public static function make()
  {
    return new static();
  }

  public function __set($key, $value)
  {
    if (method_exists($this, $method='set'.ucfirst($key))) {
      return call_user_func_array(array($this, $method), array($value));
    }

    else if (property_exists($this, $key)) {
      return $this->{$key} = $value;
    }

    throw new \Exception("Could not set [{$key}].");
  }

  public function __get($key)
  {
    if (method_exists($this, $method='get'.ucfirst($key))) {
      return call_user_func_array(array($this, $method), array());
    }

    throw new \Exception("Could not get [{$key}].");
  }

  public function with($key, $value=null)
  {
    if (is_array($key)) {
      foreach ($key as $k => $v) {
        $this->__set($k, $v);
      }
      return $this;
    }

    $this->__set($key, $value);
    return $this;
  }
}