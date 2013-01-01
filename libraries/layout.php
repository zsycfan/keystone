<?php

namespace Keystone;

class Layout extends Object {

  private $name;
  private $path;
  private $regions;

  public static function make()
  {
    throw new \Exception('Layouts must be created with an explicit name. Try `Layout::makeNamed(\'sub-page\')` instead.');
  }

  public static function makeNamed($name)
  {
    $obj = new static();
    $obj->name = $name;
    $obj->path = \Bundle::path('keystone').'tests/page.layouts/'.$name;
    return $obj;
  }

  public function addRegion(Region $region)
  {
    $this->regions[] = $region;
    return $this;
  }

  public function region($name)
  {
    foreach ($this->regions as $region) {
      if ($region->name == $name) {
        return $region;
      }
    }

    return Region::makeNamed($name);
  }

  public function getName()
  {
    return $this->name;
  }

  public function form()
  {
    return \Troup\View::make("path: {$this->path}")
      ->with('layout', $this)
      ->render()
    ;
  }
  
}
