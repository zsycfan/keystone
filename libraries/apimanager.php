<?php

namespace Keystone;

/**
 * Api Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Api Manager stores and reports
 * on the available API classes.
 */
class ApiManager extends Object {

  private static $endpoints = array();

  /**
   * ::register($name, $class)
   * ----
   *
   * Registers an API with the system.
   *
   * ```php
   * Keystone\ApiManager::register('tags', '\MyCustomNamespace\TagApi');
   * ```
   */
  public static function register($name, $class)
  {
    static::$endpoints[$name] = $class;
  }

  /**
   * ::getNamed($name)
   * ----
   *
   * Returns the class of the registered API or false on failure.
   *
   * ```php
   * Keystone\FieldManager::getNamed('tags');
   * ```
   */
  public static function getNamed($name)
  {
    return @static::$endpoints[$name];
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