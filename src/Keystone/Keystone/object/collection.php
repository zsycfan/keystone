<?php

namespace Keystone\Object;
use Keystone\Object;
use Iterator as Iterator;

class Collection extends Object implements Iterator
{

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

  public function rewind()
  {
    $this->index = 0;
  }

  public function current()
  {
    $field = $this->result[$this->index];
    return $field;
  }

  public function key()
  {
    return $this->index;
  }

  public function next()
  {
    ++$this->index;
  }

  public function valid()
  {
    return isset($this->result[$this->index]);
  }

}