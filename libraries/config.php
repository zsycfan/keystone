<?php

namespace Keystone;

class Config extends \Config
{

  public static function get_paths($key)
  {
    $paths = static::get($key);

    if (is_array($paths)) {
      foreach ($paths as &$path) {
        $path = rtrim($path, '/').'/';
      }
    }
    else {
      $paths = rtrim($paths, '/').'/';
    }

    return $paths;
  }

}