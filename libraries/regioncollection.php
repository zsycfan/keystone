<?php

namespace Keystone;

class RegionCollection extends Object
{
  private $regions = array();

  public function region($name)
  {
    return array_get($this->regions, $name);
  }
  
  public function set_region($name, $region)
  {
    array_set($this->regions, $name, $region);
  }

  public function set_regions($regions)
  {
    foreach ($regions as $region_name => $region_data) {
      $this->set_region($region_name, \Keystone\Region::make()->with('fields', $region_data));
    }
  }

  public function save()
  {
    $json = array();
    foreach ($this->regions as $region_name => $region) {
      $json[$region_name] = $region->save();
    }
    return json_encode($json);
  }
}