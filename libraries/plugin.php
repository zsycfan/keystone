<?php

namespace Keystone;

/**
 * Plugin
 * ====
 *
 * The plugin class handles starting and registering plugins with their 
 * default naming schemes.
 */
class Plugin extends Object
{

  /**
   * ::start()
   * ----
   * 
   * Loops through all registered plugin directories and either:
   *
   * 1. Includes the `start.php` file for each plugin.
   * 2. If the start file can not be loaded it calls `register` with the
   *    directory name of each plugin.
   *
   * ```php
   * Keystone\Plugin::start()
   * ```
   */
  public static function start()
  {
    foreach (FileManager::getPluginDirectoryContents() as $path) {
      if (file_exists($start = $path.'/start.php')) {
        require $start;
      }
      elseif (is_dir($path)) {
        static::register(basename($path));
      }
    }
  }

  /**
   * ::register()
   * ----
   * 
   * Passed the name of a plugin this method will register the appropriate sub
   * classes determined by the existance of specially named files. For example,
   * if a `Field` is defined in `libraries/field` it will be registered with
   * the `Keystone\Field` class.
   *
   * ```php
   * Keystone\Plugin::register('tags')
   * ```
   */
  public static function register($name)
  {
    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/Libraries/field.php")) {
      require_once $path;
      \Keystone\Field::register($name, ucfirst($name).'Field');
    }

    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/views")) {
      \Keystone\FileManager::addDirectory("fields.{$name}", $path);
    }

    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/css/field.css")) {
      \Keystone\Asset::addCssFile($path);
    }
  }
}