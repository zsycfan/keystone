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
    $index = null;
    if (strpos($key, '.') !== false) {
      $index = explode('.', $key);
      $key = array_shift($index);
      $index = implode('.', $index);
    }

	if (method_exists($this, $method='set'.ucfirst($key))) {
      return call_user_func_array(array($this, $method), array($value, $index));
    }

    $reflection = new \ReflectionClass($this);
    if ($reflection->getProperty($key)->isPublic()) {
      return $this->{$key} = $value;
    }

    $class = get_class($this);
    throw new \Exception("`{$key}` is not defined or accessible on `{$class}`.");
  }

  public function __get($key)
  {
    if (method_exists($this, $method='get'.ucfirst($key))) {
      return call_user_func_array(array($this, $method), array());
    }

    $class = get_class($this);
    throw new \Exception("`{$key}` is not defined or accessible on `{$class}`.");
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

  public function publicProperties()
  {
    $properties = array();
    $reflection = new \ReflectionClass($this);
    foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
      $properties[$name=$property->getName()] = $this->{$name};
    }
    return $properties;
  }
}