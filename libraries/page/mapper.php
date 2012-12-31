<?php

namespace Keystone\Page;
use Keystone\Object;
use Keystone\Page;

class Mapper extends Object {

  public static function map(DBResult $result)
  {
    return new Page;
  }

}
