<?php

namespace Keystone;

/**
 * Layout
 * ====
 *
 * A layout is similar to a "content type" or "channel" in traditional
 * blogging systems. Layouts setup a UI for a specific format of data,
 * whether it's a blog or a biography.
 *
 * Notable Methods
 * ----
 *
 * * ::makeWithName($name)
 * * ->addRegion(Region $region)
 * * ->renderForm($screen)
 */
class Layout extends Object {

  private $name;
  private $screen;
  private $regions = array();

  /**
   * ::makeWithName($name)
   * ----
   *
   * Creates a new layout with the specified `$name`.
   */
  public static function make()
  {
    throw new \Exception('Layouts must be created with an explicit name. Try `Layout::makeWithName(\'sub-page\')` instead.');
  }

  public static function makeWithName($name)
  {
    if (!$name) throw new \Exception('Layouts must have a name');

    $obj = new static();
    $obj->name = $name;
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

    $this->addRegion($region=Region::makeWithName($name)
      ->with('mock', true)
    );
    return $region;
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
  
}
