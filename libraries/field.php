<?php

namespace Keystone;

class Field
{

  public static function all()
  {
    $return = array();
    $field_dirs = \Keystone\Config::get_paths('keystone::field.directories');
    foreach ($field_dirs as $dir) {
      if (is_dir($dir)) {
        $fields = scandir($dir);
        foreach ($fields as $field) {
          if (substr($field, 0, 1) == '.') continue;
          $return[] = $field;
        }
      }
    }

    return $return;
  }

  public static function javascript()
  {
    $javascript = array();
    $field_dirs = \Keystone\Config::get_paths('keystone::field.directories');
    foreach ($field_dirs as $dir) {
      if (is_dir($dir)) {
        $templates = scandir($dir);
        foreach ($templates as $field) {
          if (substr($field, 0, 1) == '.') continue;
          if (!file_exists($path = path('fields').$field.'/field.js')) continue;
          $javascript[] = \File::get($path);
        }
      }
    }

    return implode('', $javascript);
  }

  public static function templates()
  {
    $return = array();
    $field_dirs = \Keystone\Config::get_paths('keystone::field.directories');
    foreach ($field_dirs as $dir) {
      if (is_dir($dir)) {
        $templates = scandir($dir);
        foreach ($templates as $field) {
          if (substr($field, 0, 1) == '.') continue;
          if (file_exists($path = $dir.$field.'/field.handlebars')) {
            $template = \File::get($path);
            $return[] = <<<EOT
              <script class="handlebars-template" data-name="field.{$field}.field" type="text/x-handlebars-template">
              {$template}
              </script>
EOT;
          }
          if (file_exists($path = $dir.$field.'/icon.handlebars')) {
            $template = \File::get($path);
            $return[] = <<<EOT
              <script class="handlebars-partial" data-name="field.{$field}.icon" type="text/x-handlebars-template">
              {$template}
              </script>
EOT;
          }
          else {
            $return[] = <<<EOT
              <script class="handlebars-partial" data-name="field.{$field}.icon" type="text/x-handlebars-template">
              <i class="icon-th-large"></i>
              </script>
EOT;
          }
        }
      }
    }

    return implode('', $return);
  }

  public static function css()
  {
    $css = array();
    $field_dirs = \Keystone\Config::get_paths('keystone::field.directories');
    foreach ($field_dirs as $dir) {
      if (is_dir($dir)) {
        $templates = scandir($dir);
        foreach ($templates as $field) {
          if (substr($field, 0, 1) == '.') continue;
          if (!file_exists($path = path('fields').$field.'/field.css')) continue;
          $css[] = \File::get($path);
        }
      }
    }

    return implode('', $css);
  }

}