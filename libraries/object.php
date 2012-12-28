<?php

namespace Keystone;

class Object
{

  public static function make()
  {
    return new static();
  }

  /**
   * Magic Set Method
   *
   * The enhanced setter below proxies the setting of data between three
   * potential routines. Each routine accepts a key that may be either a
   * property of the class or an indexed path within an array.
   *
   * For example, you can set
   * 
   *     $person->name='mark huot';
   *     // sets person::name = 'mark huot'
   *
   * or, using the index approach set:
   *
   *     $person['name.first'] = 'mark';
   *     $person['name.last'] = 'huot';
   *     // sets person::name['first'] = 'mark'
   *     // sets person::name['last'] = 'huot'
   *
   * To set the actual value a method matching the regex /set_{$key}/ will be
   * queried first. If the proper method does not exist a property on the object
   * will be set.
   */
  public function __set($key, $value)
  {
    $path = null;
    if (strpos($key, '.')) {
      $path = explode('.', $key);
      $key = array_shift($path);
    }

    if (method_exists($this, $method="set_{$key}")) {
      return call_user_func_array(array($this, $method), array($value, $path));
    }
    else if (property_exists($this, $key) && $path) {
      return array_set($this->{$key}, implode('.', $path), $value);
    }
    else if (property_exists($this, $key)) {
      return $this->{$key} = $value;
    }

    throw new \Exception("Unable to set [{$key}]");
  }

  /**
   * [__get description]
   */
  public function __get($key)
  {
    if (method_exists($this, $method=$key)) {
      return call_user_func_array(array($this, $method), array());
    }
    else if (property_exists($this, $key)) {
      return $this->{$key};
    }

    throw new \Exception("Unable to get [{$key}]");
  }

  public function with($param, $value=null)
  {
    if (is_array($param)) {
      foreach ($param as $key => $value) {
        $this->with($key, $value);
      }
      return $this;
    }

    $this->__set($param, $value);
    return $this;
  }

}