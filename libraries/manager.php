<?php

namespace Keystone;

class Manager extends Object
{
  protected static $registrations = array();
  protected $class = '\Keystone\Object';
  protected $properties = array();

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
  public static function register($label)
  {
    $obj = new static;
    static::$registrations[$label] = $obj;
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
  public static function registered($label)
  {
    return array_get(static::$registrations, $label, false);
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
    $this->properties[] = array(
      'method' => $method,
      'args' => $args,
    );
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
    $class = static::$registrations[$type]->class;
    $factoryMethod = static::$registrations[$type]->factoryMethod;
    $object = call_user_func_array(array($class, $factoryMethod), array($type));
    foreach (static::$registrations[$type]->properties as $property) {
      call_user_func_array(array($object, $property['method']), $property['args']);
    }
    return $object;
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
    return static::$registrations;
  }
}