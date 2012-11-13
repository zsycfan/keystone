<?php

namespace Keystone;

class Regions
{

  protected $regions = array();

  public function __construct($regions=array())
  {
    if ($regions && is_array($regions)) {
      foreach ($regions as $name => &$region) {
        $this->add(new \Keystone\Region(array('name' => $name, 'fields' => $region)));
      }
    }
  }

  public function __get($key)
  {
    return @$this->regions[$key];
  }

  public function __isset($key)
  {
    return isset($this->regions[$key]);
  }

  public function __set($key, $value)
  {
    $this->regions[$key] = $value;
  }

  public function add(\Keystone\Region $region)
  {
    $this->regions[$region->name] = $region;
  }

  public function to_array()
  {
    $regions = array();
    foreach ($this->regions as $region) {
      $regions[$region->name] = $region->to_array();
    }
    return $regions;
  }

  public function json()
  {
    return json_encode($this->to_array());
  }

  public function title_region()
  {
    foreach (array('title', 'name', 'heading') as $region_name) {
      if (isset($this->regions[$region_name])) {
        return $this->regions[$region_name];
      }
    }

    return new \Keystone\Region();
  }

  public function excerpt_region()
  {
    foreach (array('summary', 'description', 'content', 'body') as $region_name) {
      if (isset($this->regions[$region_name])) {
        return $this->regions[$region_name];
      }
    }

    return new \Keystone\Region();
  }

}