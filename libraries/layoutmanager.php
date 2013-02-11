<?php

namespace Keystone;

/**
 * Layout Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Layout Manager stores and reports
 * on the available layouts.
 */
class LayoutManager extends Object {

  private static $layouts = array();

  /**
   * ::register($type, $path)
   * ----
   *
   * Registers a layout with the system.
   *
   * ```php
   * Keystone\LayoutManager::register('subpage.content', '/path/to/content.php');
   * ```
   */
  public static function register($name, $path)
  {
    array_set(static::$layouts, $name, $path);
  }

  /**
   * ::getNamed($name)
   * ----
   *
   * Returns the path to the layout. If a layout view is not specificed it will
   * default to the `content` view.
   *
   * ```php
   * Keystone\LayoutManager::getNamed('subpage.content');
   * ```
   */
  public static function getNamed($name)
  {
    if (count(preg_split('/\./', $name)) < 2) {
      $name = "{name}.content";
    }

    return array_get(static::$layouts, $name);
  }

  /**
   * ::all()
   * ----
   *
   * Returns all of the registered layouts.
   * 
   * ```php
   * Keystone\LayoutManager::all();
   * ```
   */
  public static function all()
  {

  }

}