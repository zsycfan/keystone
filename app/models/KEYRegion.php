<?php

class KEYRegion {

  private $slug;

  public function setSlug($slug)
  {
    $this->slug = $slug;
  }

  public function getSlug()
  {
    return $this->slug;
  }

  public function __set($key, $value)
  {
    if (method_exists($this, 'set'.$key)) {
      return call_user_func_array(array($this, 'set'.$key), array($value));
    }
  }

  public function __get($key)
  {
    if (method_exists($this, 'get'.$key)) {
      return call_user_func_array(array($this, 'get'.$key), array());
    }

    return false;
  }

}