<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{
  protected $accessible = array(
    'regions',
    'layout',
    'uri',
    'published_at',
    'language',
    'title',
    'excerpt',
    'published'
  );

  public function set_regions($regions=array())
  {
    if (is_array($regions) && !empty($regions)) {
      foreach ($regions as $region => &$fields) {
        foreach ($fields as $index => &$field) {
          $type = $field['type'];
          if (file_exists($path = path('fields').$type.'/field.php')) {
            require_once $path;
            $class = ucfirst($type).'_Field';
            if (class_exists($class)) {
              $obj = new $class;
              if (method_exists($obj, 'save')) {
                $field = $obj->save($field);
              }
            }
          }
        }
      }
    }

    $this->attributes['regions'] = $regions;
    $this->attributes['title'] = 'title';
    $this->attributes['excerpt'] = 'excerpt';
  }

  public function get_regions()
  {
    $regions = @$this->attributes['regions'];

    if (is_array($regions)) {
      foreach ($regions as $region => &$fields) {
        foreach ($fields as $index => &$field) {
          $type = $field['type'];
          if (file_exists($path = path('fields').$type.'/field.php')) {
            require_once $path;
            $class = ucfirst($type).'_Field';
            if (class_exists($class)) {
              $obj = new $class;
              if (method_exists($obj, 'get')) {
                $field = $obj->get($field);
              }
            }
          }
        }
      }
    }

    return $regions;
  }

  public function layout_form()
  {
    return \Keystone\Layout::make($this->layout, $this->regions);
  }
}