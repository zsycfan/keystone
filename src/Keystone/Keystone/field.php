<?php

namespace Keystone\Keystone;

/**
 * Field
 * ====
 *
 * The field object represents smallest divisible piece of content within
 * Keystone. Fields are assembled into regions which are contained within
 * layouts that eventually get rendered to a page. It is the `Field` that
 * does most of the work with the database and the content of the site.
 */
class Field {

  private $type;
  private $label;
  private $path;
  private $data = array();
  private $actionable = true;
  private $iconTemplate = 'icon.twig';
  private $formTemplate = 'form.twig';

  public static function make()
  {
    throw new \Exception('Fields must be created with an explicit type. Try `Field::makeWithType(\'plain\')` instead.');
  }

  public static function makeWithType($type)
  {
    $obj = new static();
    $obj->type = $type;
    return $obj;
  }
  
  public function getType()
  {
    return $this->type;
  }

  public function getLabel()
  {
    return $this->label;
  }

  public function setLabel($label)
  {
    $this->label = $label;
    return $this;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setPath($path)
  {
    $this->path = str_finish($path, '/');
    \Keystone\Keystone\Twig::addPath($this->path, "field.{$this->type}");
    return $this;
  }

  public function setFormTemplate($formTemplate)
  {
    $this->formTemplate = $formTemplate;
    return $this;
  }

  public function getFormTemplate()
  {
    return $this->formTemplate;
  }

  public function setIconTemplate($iconTemplate)
  {
    $this->iconTemplate = $iconTemplate;
    return $this;
  }

  public function getIconTemplate()
  {
    return $this->iconTemplate;
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
  
}
