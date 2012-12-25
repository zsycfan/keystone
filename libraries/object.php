<?php

namespace Keystone;

class Object
{

  public function __set($key, $value)
  {
    if (method_exists($this, $method="set_{$key}")) {
      return call_user_func_array(array($this, $method), array($value));
    }

    throw new \Exception("Unable to set [{$key}]");
  }

  public function __get($key)
  {
    if (method_exists($this, $method="get_{$key}")) {
      return call_user_func_array(array($this, $method), array());
    }

    throw new \Exception("Unable to get [{$key}]");
  }

}