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
  private $parentLayout;
  private $parentPage;
  private $name;
  private $fields = array();
  private $allow = array();
  private $max = false;
  private $min = false;
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
   * Returns the string name of the region. This property can not be set
   * except for during initalization within the `makeWithName` static method.
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
   * parentLayout
   * ----
   *
   * Regions will commonly be nested within a layout. This property provides
   * access into that layout.
   *
   * Returns the parent `Layout` or `null` if the region is orphaned.
   *
   * ```php
   * $region = \Keystone\Region::makeWithName('body');
   * $region->parentLayout
   * ```
   */
  public function getParentLayout()
  {
    return $this->parentLayout;
  }

  public function setParentLayout(Layout $parentLayout)
  {
    $this->parentLayout = $parentLayout;
  }

  /**
   * parentPage
   * ----
   *
   * Regions will commonly be nested within a page. This property provides
   * access into that page.
   *
   * Returns the parent `Page` or `null` if the region is orphaned.
   *
   * ```php
   * $region = \Keystone\Region::makeWithName('body');
   * $region->parentPage
   * ```
   */
  public function getParentPage()
  {
    return $this->parentPage;
  }

  public function setParentPage(Page $parentPage)
  {
    $this->parentPage = $parentPage;
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
   * This field additionallh controls the presence of the Add Field
   * button within the UI. If the number of fields meets or
   * exceeds the max, the add field button will be hidden.
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
    return $this->allow ?: FileManager::getFieldDirectoryContents();
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
      ->with('region', $this)
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
