<?php

class KEYContentType {

  public function getSlug()
  {
    return 'home';
  }

  public function __get($key)
  {
    if (method_exists($this, 'get'.$key)) {
      return call_user_func_array(array($this, 'get'.$key), array());
    }

    return false;
  }

}