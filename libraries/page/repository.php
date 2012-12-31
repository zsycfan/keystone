<?php

namespace Keystone\Page;
use Keystone\Object;
use Keystone\Page;

class Repository extends Object {

  public static function all()
  {
    return Collection::make();
  }

  public static function find($id)
  {
    return Page::make();
  }

}
