<?php

namespace Keystone;

class Layout extends Object {

  private $name;
  private $regions = array();

  public static function make()
  {
    throw new \Exception('Layouts must be created with an explicit name. Try `Layout::makeWithName(\'sub-page\')` instead.');
  }

  public static function makeWithName($name)
  {
    if (!$name) throw new \Exception('Layouts must have a name');

    $obj = new static();
    $obj->name = $name;
    View::makeLayout("{$obj->name}/content")
      ->with('layout', $obj)
      ->render()
    ;
    return $obj;
  }

  public function addRegion(Region $region)
  {
    foreach ($this->regions as &$existingRegion) {
      if ($region->name == $existingRegion->name) {
        $existingRegion = $region;
        return $this;
      }
    }

    $this->regions[] = $region;
    return $this;
  }

  public function getRegion($name)
  {
    foreach ($this->regions as $region) {
      if ($region->name == $name) {
        return $region;
      }
    }

    return $this->regions[] = Region::makeWithName($name)
      ->with('mock', true)
    ;
  }

  public function getRegions()
  {
    return $this->regions;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function renderForm($name=null)
  {
    return View::makeLayout("{$this->name}/{$name}")
      ->with('layout', $this)
      ->render()
    ;
  }
  
}
