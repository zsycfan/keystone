<?php

namespace Keystone;

class View extends Object
{

  private static $handlers = array();
  private static $directories = array();
  
  public static function reset()
  {
    static::$handlers = array();
    static::$directories = array();
  }

  public static function addHandler($extension, $class)
  {
    static::$handlers[$extension] = $class;
  }
  
  public static function addDirectory($group, $directory)
  {
    static::$directories[$group][] = str_finish($directory, '/');
  }

  public static function __callStatic($method, $args)
  {
    if (preg_match('/^make(.*)$/', $method, $group)) {
      return call_user_func_array('Keystone\View::makeGroup', array(strtolower($group[1]), $args[0]));
    }
  }

  public static function makeGroup($group, $name)
  {
    $directories = static::$directories[$group];
    foreach ($directories as $dir) {
      foreach (static::$handlers as $ext=>$handler) {
        if (file_exists($path=$dir.$name.$ext)) {
          return new $handler($dir, $name, $ext);
        }
      }
    }
    
    throw new \Exception("Could not find view for: {$group}::{$name}");
  }

}
