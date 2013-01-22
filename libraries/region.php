<?php

/**
 * Region
 * ====
 * 
 * Regions are the editable areas within a layout. They can be
 * configured to have one or more fields representing the data
 * of the region.
 *
 * Initialization & Identificafion
 * 
 * * [makeWithName]()
 * * [name]()
 *
 * Managing Settings
 *
 * * [max]()
 * * [min]()
 *
 * Adding and removing Fields
 *
 * * [addField]()
 *
 * ----
 */

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
  private $mock = false;

  /**
   * makeWithName($name)
   * ----
   *
   * Creates a new region specified by the passed name
   * parameter. Regions are always referred to by name and never
   * by an index or other identifier.
   *
   * ```php
   * $region = \Keystone\Region::makeWithName('body');
   * ```
   */
  public static function make()
  {
    throw new \Exception('Regions must be created with an explicit name. Try `Region::makeWithName(\'body\')` instead.');
  }

  public static function makeWithName($name)
  {
    $obj = new static();
    $obj->name = $name;
    return $obj;
  }

  /**
   * name
   * ----
   *
   * Returns the string name of the region.
   *
   * ```php
   * $region = \Keystone\Region::makeWithName('body');
   * $region->name // returns "body"
   * ```
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * max
   * ----
   *
   * Configures the maximum number of fields this region 
   * may contain. This setting only affects new fields, if it
   * is updated and existing regions exceed the max their content
   * will remain as is, yet uneditable, until the number of
   * fields is reduced.
   *
   * ```php
   * \Keystone\Region::makeWithName('body')->max = 3;
   * ```
   */
  public function setMax($max)
  {
    $this->max = $max;
  }

  public function setMin($min)
  {
    $this->min = $min;
  }

  public function getAllow()
  {
    return $this->allow ?: Keystone\FileManager::getFieldDirectoryContents();
  }

  public function setAllow(array $allow)
  {
    $this->allow = $allow;
  }

  public function setConfig($config, $index)
  {
    array_set($this->config, $index, $config);
  }

  public function getMock()
  {
    return $this->mock;
  }

  public function setMock($mock)
  {
    $this->mock = $mock;
  }

  public function addField(Field $field)
  {
    $this->addFieldAtIndex(count($this->fields), $field);
    return $this;
  }

  public function addFieldAtIndex($index, Field $field)
  {
    $this->fields[$index] = $field;
    $this->count = count($this->fields);
    return $this;
  }
  
  public function getFieldAtIndex($index)
  {
    return @$this->fields[$index];
  }

  public function getFields()
  {
    return $this->fields;
  }

  public function getSummary($glue=' ')
  {
    $summary = array();
    foreach ($this->fields as $field) {
      $summary[] = $field->summary;
    }
    return trim(implode($glue, $summary));
  }

  public function renderForm()
  {
    return View::makeView('region/form')
      ->with('name', $this->name)
      ->with('fields', $this->fields)
      ->with('allow', $this->allow)
      ->with('max', $this->max)
      ->with('min', $this->min)
      ->with('count', $this->count)
      ->with('config', $this->config)
      ->render()
    ;
  }

}
