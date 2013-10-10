<?php

class KEYContent {

  private $type;
  private $elements = array();

  public function getType()
  {
    return $this->type;
  }

  public function setType(KEYContentType $type)
  {
    $this->type = $type;
  }

  public function addElement(KEYContentElement $element)
  {
    $this->elements[$element->region->slug][] = $element;
  }

  public function __set($key, $value)
  {
    if (method_exists($this, 'set'.$key)) {
      return call_user_func_array(array($this, 'set'.$key), array($value));
    }

    throw new Exception('Model attribute `'.$key.'` not defined.');
  }

  public function __get($key)
  {
    if (method_exists($this, 'get'.$key)) {
      return call_user_func_array(array($this, 'get'.$key), array());
    }

    if (isset($this->elements[$key])) {
      return $this->elements[$key];
    }

    throw new Exception('Model attribute `'.$key.'` not defined.');
  }

}