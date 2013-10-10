<?php

class KEYContentElement {

  private $region;
  private $revisions = array();
  private $publishedRevision;

  public function setRegion(KEYRegion $region)
  {
    $this->region = $region;
  }

  public function getRegion()
  {
    return $this->region;
  }

  public function addRevision(KEYRevision $revision)
  {
    $this->revisions[] = $revision;
    if ($revision->published) {
      $this->publishedRevision = $revision;
    }
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