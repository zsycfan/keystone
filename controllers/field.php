<?php

use Keystone\FileManager;

class Keystone_Field_Controller extends Keystone_Base_Controller
{
  public function get_css()
  {
    $css = array();

    $dirs = FileManager::getFieldDirectory();
    foreach ($dirs as $dir) {
      if (is_dir($dir)) {
        $fields = scandir($dir);
        foreach ($fields as $field) {
          if (substr($field, 0, 1) == '.') continue;
          $css[] = @file_get_contents($dir.$field.'/field.css');
        }
      }
    }

    return implode(' ', $css);
  }
}