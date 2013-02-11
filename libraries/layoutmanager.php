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
   * Keystone\LayoutManager::register('subpage.content', '/path/to/layout.php');
   * ```
   */
  public static function register($name, $path)
  {
    static::$layouts[$name] = $path;
  }

  /**
   * ::getClassOfType($type)
   * ----
   *
   * Returns the class of the registered field type or false on failure.
   *
   * ```php
   * Keystone\LayoutManager::getClassOfType('tags');
   * ```
   */
  public static function getClassOfType($type)
  {
    return @static::$types[$type];
  }

  /**
   * ::all()
   * ----
   *
   * Returns all of the registered field types.
   * 
   * ```php
   * Keystone\LayoutManager::all();
   * ```
   */
  public static function all()
  {

  }

}