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

  public static function addHandler($extension, $className)
  {
    static::$handlers[$extension] = $className;
  }
  
  public static function addDirectory($group, $directory)
  {
    static::$directories[$group] = array_unique(array_merge(
      @static::$directories[$group] ?: array(),
      array(str_finish($directory, '/'))
    ));
  }

  public static function __callStatic($method, $args)
  {
    if (preg_match('/^make(.*)$/', $method, $group)) {
      return call_user_func_array('Keystone\View::makeGroup', array(strtolower($group[1]), $args[0]));
    }
    if (preg_match('/^add(.*)Directory$/', $method, $group)) {
      return call_user_func_array('Keystone\View::addDirectory', array(strtolower($group[1]), $args[0]));
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
    
    throw new \Exception("Could not find {$group} at `{$name}`. Searched (".implode(', ', $directories).")");
  }

}
