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

  private static $fields = array();

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
  public static function register($type)
  {
    $field = Field::makeWithType($type);
    array_set(static::$fields, $type, $field);
    return $field;
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
  public static function getType($type)
  {
    return array_get(static::$types, $type);
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