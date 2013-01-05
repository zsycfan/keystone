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
  
  public function with($key, $value)
  {
    $this->data[$key] = $value;
    return $this;
  }
  
  public function render()
  {
  
  }
}