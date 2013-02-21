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
    foreach (FileManager::getPluginDirectory() as $directory) {
      if (is_dir($directory)) {
        $plugins = scandir($directory);
        foreach ($plugins as $plugin) {
          if (substr($plugin, 0, 1) == '.') continue;
          if (file_exists($start=str_finish(str_finish($directory, '/').$plugin, '/').'start.php')) {
            require $start;
          }
        }
      }
    }
  }
}