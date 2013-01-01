<?php

namespace Keystone\Page;

class Collection extends \Keystone\Object {

  protected $result;
  protected $index = 0;

  public static function makeWithResult(array $result)
  {
    return new static($result);
  }

  public function __construct(array $result)
  {
    $this->result = $result;
  }

}