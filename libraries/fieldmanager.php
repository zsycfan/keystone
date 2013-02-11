<?php

namespace Keystone;

/**
 * Field Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Field Manager stores and reports
 * on the available fields.
 */
class FieldManager extends Object {

  private static $types = array();

  /**
   * ::register($type, $class)
   * ----
   *
   * Registers a field type with the system.
   *
   * ```php
   * Keystone\FieldManager::register('tags', '\MyCustomNamespace\TagField');
   * ```
   */
  public static function register($type, $class)
  {
    static::$types[$type] = $class;
  }

  /**
   * ::getClassOfType($type)
   * ----
   *
   * Returns the class of the registered field type or false on failure.
   *
   * ```php
   * Keystone\FieldManager::getClassOfType('tags');
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
   * Keystone\FieldManager::all();
   * ```
   */
  public static function all()
  {

  }

}