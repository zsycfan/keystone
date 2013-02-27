<?php

namespace Keystone;

class View extends Object
{

  private static $handlers = array();
  
  public static function reset()
  {
    static::$handlers = array();
  }

  public static function addHandler($extension, $className)
  {
    static::$handlers[$extension] = $className;
  }

  public static function __callStatic($method, $args)
  {
    if (preg_match('/^make(.*)$/', $method, $type)) {
      return static::makeWithType(strtolower($type[1]), $args[0]);
    }
  }

  public static function makeWithType($type, $name)
  {
    $directories = call_user_func_array("Keystone\FileManager::getDirectory", array($type));
    foreach ($directories as $dir) {
      foreach (static::$handlers as $ext=>$handler) {
        if (file_exists($path=$dir.$name.$ext)) {
          return new $handler($dir, $name, $ext);
        }
      }
    }
    
    throw new \Exception("Could not find {$type} at `{$name}`. Searched (".implode(', ', $directories).")");
  }

}
