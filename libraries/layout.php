<?php

namespace Keystone;

class Layout extends Object {

  private $name;
  private $regions = array();
  private static $directories = array();

  public static function addDirectory($dir)
  {
    static::$directories[] = str_finish($dir, '/');
  }

  public static function getAll()
  {
    $return = array();
    $dirs = static::$directories;
    foreach ($dirs as $dir) {
      if (is_dir($dir)) {
        $layouts = scandir($dir);
        foreach ($layouts as $layout) {
          if (substr($layout, 0, 1) == '.') continue;
          $return[] = $layout;
        }
      }
    }

    return $return;
  }

  public static function make()
  {
    throw new \Exception('Layouts must be created with an explicit name. Try `Layout::makeWithName(\'sub-page\')` instead.');
  }

  public static function makeWithName($name)
  {
    $obj = new static();
    $obj->name = $name;
    return $obj;
  }

  public function addRegion(Region $region)
  {
    $this->regions[] = $region;
    return $this;
  }

  public function getRegion($name)
  {
    foreach ($this->regions as $region) {
      if ($region->name == $name) {
        return $region;
      }
    }

    return Region::makeWithName($name);
  }

  public function getName()
  {
    return $this->name;
  }

  public function renderForm($name=null)
  {
    return View::makeLayout("{$this->name}/{$name}")
      ->with('layout', $this)
      ->render()
    ;
  }
  
}
