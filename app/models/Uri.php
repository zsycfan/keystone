<?php

class Uri {

  private $segments = array();

  public function __construct($uri)
  {
  	$this->segments = array_merge(array_filter(preg_split('#/#', $uri)));
  }

  public function string()
  {
  	return $this->__toString();
  }

  public function __toString()
  {
  	return implode('/', $this->segments);
  }

}