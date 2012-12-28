<?php

namespace Keystone;

require \Bundle::path('keystone').'libraries'.DS.'layout'.DS.'helper'.EXT;

class Layout extends Object {

  private static $active;
  public $name = null;
  public $page = null;

  public static function all()
  {
    $layouts = array();
    $layout_dirs = \Keystone\Config::get_paths('keystone::layout.directories');
    foreach ($layout_dirs as $dir) {
      if (is_dir($dir)) {
        $layout_files = scandir($dir);
        foreach ($layout_files as $layout) {
          if (substr($layout, 0, 1) == '.') continue;
          $layouts[] = $layout;
        }
      }
    }
    return $layouts;
  }

  public static function active()
  {
    return static::$active;
  }

  public function set_active()
  {
    static::$active = $this;
  }

  public function release_active()
  {
    static::$active = null;
  }

  public static function path($name)
  {
    $components = preg_split('/\./', $name);
    if (count($components) < 1) {
      $components = array_unshift($components, 'content');
    }

    foreach (\Keystone\Config::get_paths('keystone::layout.directories') as $dir) {
      if (file_exists($path = $dir.$components[0].'/'.$components[1].EXT)) {
        return $path;
      }
    }

    return \Bundle::path('keystone').'layouts/content/'.$components[1].EXT;
  }

  public function form($page, $screen='content')
  {
    $this->set_active();
    $page->set_active();

    $form = \Laravel\View::make('path: '.static::path("{$this->name}.{$screen}"))
      ->__toString()
    ;

    $this->release_active();
    $page->release_active();

    return $form;
  }

}