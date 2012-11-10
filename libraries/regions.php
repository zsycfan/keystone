<?php

namespace Keystone;

class Regions
{

  public function __construct($regions=array())
  {
    foreach ($regions as $region => $fields) {
      $this->$region = $fields;
    }
  }

}