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
   * Registers a field type with the system. Once registered this method returns
   * a configurable object which will pass it's values on to the final object.
   *
   * ```php
   * Keystone\FieldManager::register('tags')
   *   ->setPath('/path/to/files')
   *   ->setLabel('Some Label')
   * ;
   * ```
   */
  public static function register($type)
  {
    $obj = new static;
    static::$fields[$type] = $obj;
    return $obj;
  }

  /**
   * ::registered($type)
   * ----
   *
   * If an object has already been registered with the assigned type it will be
   * returned. If not it will return false.
   *
   * ```php
   * Keystone\FieldManager::registered('tags');
   * ```
   */
  public static function registered($type)
  {
    return array_get(static::$fields, $type, false);
  }

  /**
   * Magic Methods
   * ----
   *
   * A call to a management's `register` method returns an empty object that can
   * accept any method. We do this by overriding the `__call` method and storing
   * any methods for later use on the actual object.
   */
  public function __call($method, $args)
  {
    $this->properties[$method] = $args;
    return $this;
  }

  /**
   * ->setClass($class)
   * ----
   *
   * The one method not overridden by a management class is the `setClass`
   * method. This allows us to control which class will be used when the final
   * object is instantiated.
   */
  public function setClass($class)
  {
    $this->class = $class;
    return $this;
  }

  /**
   * ::get($type)
   * ----
   *
   * Returns an instantiated class of the requested type, applying any set
   * properties first.
   *
   * ```php
   * Keystone\FieldManager::get('tags');
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