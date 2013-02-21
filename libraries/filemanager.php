<?php

namespace Keystone;

class FileManager extends Object {

  private static $directories = array();
  
  public static function reset()
  {
    static::$directories = array();
  }

  public static function __callStatic($method, $args)
  {
    if (preg_match('/^add(.*)Directory$/', $method, $group)) {
      array_unshift($args, $group[1]);
      return call_user_func_array('Keystone\FileManager::addDirectory', $args);
    }
    if (preg_match('/^get(.*)Directory$/', $method, $group)) {
      return call_user_func_array('Keystone\FileManager::getDirectory', array($group[1]));
    }
  }

  public static function addDirectory()
  {
    $directories = func_get_args();
    $group = strtolower(array_shift($directories));
    foreach ($directories as $directory) {
      static::$directories[$group] = array_unique(array_merge(
        @static::$directories[$group] ?: array(),
        array(str_finish($directory, '/'))
      ));
    }
  }

  public static function getDirectory($key)
  {
    if ($directories = @static::$directories[strtolower($key)]) {
      return $directories;
    }

    throw new \Exception("Could not find any `{$key}` directories.");
  }

}