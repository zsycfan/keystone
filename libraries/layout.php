<?php

namespace Keystone;

class Layout extends Object {

  private $parentPage;
  private $name;
  private $screen;
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
    return $obj;
  }
  
  /**
   * parentPage
   * ----
   *
   * Regions will commonly be nested within a page. This property provides
   * access into that page.
   *
   * Returns the parent `Page` or `null` if the region is orphaned.
   *
   * ```php
   * $region = \Keystone\Region::makeWithName('body');
   * $region->parentPage
   * ```
   */
  public function getParentPage()
  {
    return $this->parentPage;
  }

  public function setParentPage(Page $parentPage)
  {
    $this->parentPage = $parentPage;
  }

  public function addRegion(Region $region)
  {
    $region->parentLayout = $this;
    $region->parentPage = $this->parentPage;

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

  public function getScreen()
  {
    return $this->screen;
  }

  public function setScreen($screen)
  {
    $this->screen = $screen;
  }

  public function renderForm($name=null)
  {
    $this->screen = $name;
    $form = View::makeLayout("{$this->name}/{$name}")
      ->with('layout', $this)
      ->render()
    ;
    $this->screen = null;
    return $form;
  }
  
}
