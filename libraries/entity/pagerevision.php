<?php

namespace Keystone\Entity;

class PageRevision
{

  public function __construct($data)
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

}