<?php

namespace Keystone\Entity;

class Page
{
  public function __construct($data)
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  public function layout_form()
  {
    return \Keystone\Layout::make($this->layout, $this->regions);
  }
}