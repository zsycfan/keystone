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
   * classes determined by the existance of conventionally named files.
   *
   * ```php
   * Keystone\Plugin::register('tags')
   * ```
   *
   * When called it looks for the following:
   *
   * * `libraries/field.php` to define a `TagsField` class which will respond
   *   to sleep and wakeup events.
   * * `css/field.css` for display of the field UI
   * * `javascript/field.js` for display of the field UI
   * * `views` folder, used to render `views/field.twig` in the field UI
   * * `layouts` folder, which contains one or more layouts provided by the
   *   plugin
   * * `libraries/api.php` to define a `TagsApi` class which will respond to
   *   API calls from the browser.
   */
  public static function register($name)
  {
    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/libraries/field.php")) {
      require_once $path;
      \Keystone\FieldManager::register($name, ucfirst($name).'Field');
    }

    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/views/")) {
      \Keystone\FileManager::addDirectory("fields.{$name}", $path);
    }

    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/css/field.css")) {
      \Keystone\Asset::addCssFile($path);
    }

    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/javascript/field.js")) {
      \Keystone\Asset::addJavascriptFile($path);
    }

    if (file_exists($path=\Bundle::path('keystone')."plugins/{$name}/libraries/api.php")) {
      require_once $path;
      \Keystone\ApiManager::register($name, ucfirst($name).'Api');
    }

    if (is_dir($path=\Bundle::path('keystone')."plugins/{$name}/layouts/")) {
      \Keystone\FileManager::addDirectory("layouts.{$name}", $path);
    }
  }
}