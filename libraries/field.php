<?php

namespace Keystone;

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
    if ($class = FieldManager::getClassOfType($type)) {
      $obj = new $class;
    }
    else {
      $obj = new static();
    }
    
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
    return $this;
  }

  public function getActionable()
  {
    return $this->actionable;
  }

  /**
   * Set Data
   * ----
   *
   * Setting the data of a field can happen in many different ways. We
   * could be pulling the data out of a data repository (the database)
   * or parsing user input throuth the POST. Because of this the Field
   * object provides named methods for each. They are:
   * 
   * * setDataFromDatabase
   * * setDataFromPost
   */
  public function setData($data)
  {
    $this->data = $data;
    return $this;
  }
  public function setDataFromDatabase($data)
  {
    return $this->setData($data);
  }
  public function setDataFromPost($data)
  {
    return $this->setData($data);
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
    $form = View::makeWithType('fields.'.$this->type, 'form')
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
