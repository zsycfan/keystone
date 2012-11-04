<?php

class Field
{

  public static function all()
  {
    $fields = array();
    $field_dirs = scandir(path('fields'));
    foreach ($field_dirs as $field) {
      if (substr($field, 0, 1) == '.') continue;
      $fields[] = $field;
    }

    return $fields;
  }

  public static function javascript()
  {
    $javascript = array();
    $field_templates = scandir(path('fields'));
    foreach ($field_templates as $field) {
      if (substr($field, 0, 1) == '.') continue;
      if (!file_exists($path = path('fields').$field.'/field.js')) continue;
      $javascript[] = File::get($path);
    }

    return implode('', $javascript);
  }

  public static function handlebars_templates()
  {
    $templates = array();
    $field_templates = scandir(path('fields'));
    foreach ($field_templates as $field) {
      if (substr($field, 0, 1) == '.') continue;
      if (file_exists($path = path('fields').$field.'/field.handlebars')) {
        $template = File::get($path);
        $templates[] = <<<EOT
          <script class="handlebars-template" data-name="field.{$field}.field" type="text/x-handlebars-template">
          {$template}
          </script>
EOT;
      }
      if (file_exists($path = path('fields').$field.'/icon.handlebars')) {
        $template = File::get($path);
        $templates[] = <<<EOT
          <script class="handlebars-partial" data-name="field.{$field}.icon" type="text/x-handlebars-template">
          {$template}
          </script>
EOT;
      }
      else {
        $templates[] = <<<EOT
          <script class="handlebars-partial" data-name="field.{$field}.icon" type="text/x-handlebars-template">
          <i class="icon-th-large"></i>
          </script>
EOT;
      }
    }

    return implode('', $templates);
  }

  public static function css()
  {
    $css = array();
    $field_templates = scandir(path('fields'));
    foreach ($field_templates as $field) {
      if (substr($field, 0, 1) == '.') continue;
      if (!file_exists($path = path('fields').$field.'/field.css')) continue;
      $css[] = File::get($path);
    }

    return implode('', $css);
  }

}