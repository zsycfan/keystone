<?php

namespace Keystone;

/**
 * Asset
 * ====
 *
 * The `Asset` class accepts any number of static files which will later be
 * rendered to the display. It consists of a single magic method which accepts
 * any type of asset to be called back later.
 *
 * To add a CSS file, for example you could run,
 *
 * ```php
 * Keystone\Asset::addCssFile('/path/to/file.css');
 * ```
 *
 * Also available is passing in the raw source,
 *
 * ```php
 * Keystone\Asset::addCss('* html * { display:none; }');
 * ```
 *
 * Finally, you can retrieve any set asset with a similar get method,
 *
 * ```php
 * Keystone\Asset::getCss();
 * ```
 */
class Asset extends Object
{
  private static $contents = array();

  public static function __callStatic($method, $args)
  {
    if (preg_match('/^add(.*)File$/', $method, $type)) {
      static::$contents[$type[1]][] = file_get_contents($args[0]);
      return true;
    }
    if (preg_match('/^add(.*)$/', $method, $type)) {
      static::$contents[$type[1]][] = $args[0];
      return true;
    }
    if (preg_match('/^get(.*)$/', $method, $type)) {
      return implode(' ', @static::$contents[$type[1]]?:array());
    }

    return false;
  }
}