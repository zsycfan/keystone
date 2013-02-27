<?php

namespace Keystone;

class Screen extends Object
{

  private $name;
  private $label;
  private $path;

  /**
   * ::makeWithName($name)
   * ----
   *
   * Creates a new Screen with the specified `$name`.
   */
  public static function make()
  {
    throw new \Exception('Screens must be created with an explicit name. Try `Screen::makeWithName(\'sub-page\')` instead.');
  }

  public static function makeWithName($name, $path, $label)
  {
    if (!$name) throw new \Exception('Screens must have a name');

    $obj = new static();
    $obj->name = $name;
    $obj->path = $path;
    $obj->label = $label;
    return $obj;
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

  public function getLabel()
  {
    return $this->label;
  }

  public function setLabel($label)
  {
    $this->label = $label;
    return $this;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setPath($path)
  {
    $this->path = $path;
    return $this;
  }

}