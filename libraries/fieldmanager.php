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
  private $class = '\Keystone\Field';
  private $properties = array();

  /**
   * ::register($type)
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

  public function setClass($class)
  {
    $this->class = $class;
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
  public static function get($type)
  {
    $class = static::$fields[$type]->class;
    $field = call_user_func_array(array($class, 'makeWithType'), array($type));
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