<?php

namespace Keystone;

require_once(\Bundle::path('keystone').'fields/plain/field.php');

class Field extends Object {

  private $type;
  private $data = array();
  private $actionable = true;

  public static function make()
  {
    throw new \Exception('Fields must be created with an explicit type. Try `Field::makeWithType(\'plain\')` instead.');
  }

  public static function makeWithType($type)
  {
    $obj = new static();
    $obj = new Fields\Plain\Field();
    $obj->type = $type;
    return $obj;
  }
  
  public function getType()
  {
    return $this->type;
  }

  public function setActionable($actionable)
  {
    $this->actionable = $actionable;
  }

  public function getActionable()
  {
    return $this->actionable;
  }

  public function setData($data)
  {
    $this->data = $data;
    return $this;
  }
  
  public function addData($key, $value=null)
  {
    $this->data[$key] = $value;
    return $this;
  }

  public function getData()
  {
    return $this->data;
  }

  public function getSummary()
  {
    return @$this->data['content'];
  }

  public function renderIcon()
  {
  }

  public function renderForm()
  {
    $form = View::makeField($this->type.'/form')
      ->with($this->publicProperties())
      ->with('type', $this->type)
      ->with('data', $this->data)
      ->with('actionable', $this->actionable)
      ->with('icon', $this->renderIcon())
      ->render()
    ;

    return View::makeView('field/form')
      ->with('type', $this->type)
      ->with('data', $this->data)
      ->with('actionable', $this->actionable)
      ->with('icon', $this->renderIcon())
      ->with('form', $form)
      ->render()
    ;
  }
  
}
