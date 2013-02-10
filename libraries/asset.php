<?php

namespace Keystone;

class Asset extends Object
{
  private static $contents = array();

  public static function __callStatic($method, $args)
  {
    if (preg_match('/^add(.*)File$/', $method, $type)) {
      static::$contents[$type[1]][] = file_get_contents($args[0]);
      return true;
    }
    if (preg_match('/^add(.*)$/', $method, $type)) {
      static::$contents[$type[1]][] = $args[0];
      return true;
    }
    if (preg_match('/^get(.*)$/', $method, $type)) {
      return implode(' ', @static::$contents[$type[1]]?:array());
    }

    return false;
  }
}