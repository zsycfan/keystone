<?php

namespace Keystone\Page;

class Repository extends \Keystone\Object {

  public static function all()
  {
    return Collection::make();
  }

  public static function find($id)
  {
    return \Keystone\Page::make();
  }

}
