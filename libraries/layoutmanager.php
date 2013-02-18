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
  public static function register($name)
  {
    $layout = Layout::makeWithName($name);
    array_set(static::$layouts, $name, $layout);
    return $layout;
  }

  /**
   * ::getNamed($name)
   * ----
   *
   * Returns the layout object.
   *
   * ```php
   * Keystone\LayoutManager::getNamed('subpage.content');
   * ```
   */
  public static function getNamed($name)
  {
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