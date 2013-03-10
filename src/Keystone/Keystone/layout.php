<?php

namespace Keystone\Keystone;

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
 */
class Layout {

  private $name;
  private $label;
  private $path;
  private $screens = array();
  private $regions = array();
  protected $titleRegion = 'title';
  protected $descriptionRegion = 'body';
  protected $thumbnailRegion = 'image';

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
      if ($region->getName() == $existingRegion->getName()) {
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
      if ($region->getName() == $name) {
        return $region;
      }
    }

    $region = Region::makeWithName($name)->setMock(true);
    $this->addRegion($region);
    return $region;
  }

  public function getTitleRegion()
  {
    return $this->getRegion($this->titleRegion);
  }

  public function getDescriptionRegion()
  {
    return $this->getRegion($this->descriptionRegion);
  }

  public function getThumbnailRegion()
  {
    return $this->getRegion($this->thumbnailRegion);
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
    return $this;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setPath($path)
  {
    $this->path = str_finish($path, '/');
    \Keystone\Keystone\Twig::addPath($this->path, "layout.{$this->name}");
    return $this;
  }

  public function getLabel()
  {
    return $this->label;
  }

  public function setLabel($label)
  {
    $this->label = $label;
    return $this;
  }

  public function getScreens()
  {
    return $this->screens;
  }

  public function getScreen($screen_name)
  {
    return array_get($this->screens, $screen_name);
  }

  public function addScreen(Screen $screen)
  {
    array_set($this->screens, $screen->getName(), $screen);
    return $this;
  }
  
}
