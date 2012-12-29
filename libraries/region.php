<?php

namespace Keystone;

class Region extends Object
{
  private $name;
  private $fields = array();
  private $allow = array();
  private $max = 0;
  private $min = 0;
  private $count = 0;
  private $config = array();

  public static function make()
  {
    throw new \Exception('Regions must be created with an explicit name. Try `Region::makeNamed(\'body\')` instead.');
  }

  public static function makeNamed($name)
  {
    $obj = new static();
    $obj->name = $name;
    return $obj;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setMax($max)
  {
    $this->max = $max;
  }

  public function setMin($min)
  {
    $this->min = $min;
  }

  public function setAllow(array $allow)
  {
    $this->allow = $allow;
  }

  public function addField(Field $field)
  {
    $this->addFieldAt(count($this->fields), $field);
    return $this;
  }

  public function addFieldAt($index, Field $field)
  {
    $this->fields[$index] = $field;
    $this->count = count($this->fields);
    return $this;
  }

  public function form()
  {
    return View::make('keystone::region.form')
      ->with('fields', $this->fields)
      ->with('name', $this->name)
      ->with('allow', $this->allow)
      ->with('max', $this->max)
      ->with('min', $this->min)
      ->with('count', $this->count)
      ->with('config', $this->config)
      ->render()
    ;
  }

}