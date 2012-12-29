<?php

namespace Keystone\Page;

class Repository extends \Keystone\Object {

  public function all()
  {
    return Collection::make();
  }

  public function find($id)
  {
    return \Keystone\Page::make();
  }

}