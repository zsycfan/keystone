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

  public $type = null;
  public $properties = array();

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
    $obj = new static;
    static::$fields[$type] = $obj;
    return $obj;
  }

  public function __call($method, $args)
  {
    $this->properties[$method] = $args;
    return $this;
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
    $field = Field::makeWithType($type);
    foreach (static::$fields[$type]->properties as $method => $args) {
      call_user_func_array(array($field, $method), $args);
    }
    return $field;
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