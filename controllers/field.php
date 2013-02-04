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

    return Response::make(implode(' ', $css), 200, array(
      'Content-type' => 'text/css',
    ));
  }
  
  public function get_javascript()
  {
    $javascript = array();

    $dirs = FileManager::getFieldDirectory();
    foreach ($dirs as $dir) {
      if (is_dir($dir)) {
        $fields = scandir($dir);
        foreach ($fields as $field) {
          if (substr($field, 0, 1) == '.') continue;
          $javascript[] = @file_get_contents($dir.$field.'/field.js');
        }
      }
    }

    return Response::make(implode(' ', $javascript), 200, array(
      'Content-type' => 'text/javascript',
    ));
  }
}