<?php

namespace Keystone\View;
use Keystone\Object;

class Renderer extends Object
{
  private $directory;
  private $name;
  private $extension;
  private $data = array();

  public function __construct($directory, $name, $extension)
  {
    $this->directory = $directory;
    $this->name = $name;
    $this->extension = $extension;
  }

  public function __toString()
  {
    return $this->render();
  }

  public function directory()
  {
    return $this->directory;
  }

  public function name()
  {
    return $this->name;
  }

  public function extension()
  {
    return $this->extension;
  }

  public function data()
  {
    return $this->data;
  }

  public function path()
  {
    return $this->directory.$this->name.$this->extension;
  }
  
  public function with($key, $value=null)
  {
    if (is_array($key)) {
      foreach ($key as $property => $value) {
        $this->with($property, $value);
      }
      return $this;
    }

    $this->data[$key] = $value;
    return $this;
  }
  
  public function render()
  {
    return file_get_contents($this->path());
  }
}