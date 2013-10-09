<?php

namespace Lascaux;

use Countable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Contracts\JsonableInterface;

class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonableInterface {

  /**
   * Raw array of items
   * 
   * @var array
   */
  private $items = array();

  /**
   * Add an item to the array.
   *
   * This method also checks to be sure we're not inserting two elements into
   * the collection with the same primary key. This way you can parse over
   * nested/repeated results and blindly add them to the collection without
   * worrying that they will appear twice.
   * 
   * @param Lascaux model object
   * @return Lascaux model object
   */
  public function add(\Lascaux $newItem)
  {
    if ($item=$this->find($newItem)) {
      return $item;
    }
    
    $this->items[] = $newItem;
    return $newItem;
  }

  /**
   * Returns the values of a specific column across the collection.
   * 
   * @param string $key
   * @return array
   */
  public function getColumn($key)
  {
    $values = array();
    foreach ($this->items as $item) {
      $values[] = $item->{$key};
    }
    return $values;
  }

  /**
   * Converts the collection to a JSON string.
   * 
   * @param  integer $options
   * @return string
   */
  public function toJson($options=0)
  {
    $items = array();
    foreach ($this->items as $item) {
      $items[] = $item->toJson();
    }
    return '['.implode(',',$items).']';
  }

  public function offsetExists($key)
  {
    return array_key_exists($key, $this->items);
  }

  public function offsetGet($key)
  {
    return $this->items[$key];
  }

  public function offsetSet($key, $value)
  {
    if (is_null($key))
    {
      $this->items[] = $value;
    }
    else
    {
      $this->items[$key] = $value;
    }
  }

  public function offsetUnset($key)
  {
    unset($this->items[$key]);
  }

  public function getIterator()
  {
    return new ArrayIterator($this->items);
  }

  public function count()
  {
    return count($this->items);
  }

  /**
   * Finds an element by key
   *
   * If a model is passed in it will search the items for matching primary
   * keys automatically.
   * 
   * @param integer/Lascaux model object
   * @return Lascaux model object
   */
  public function find($id)
  {
    if (is_a($id, 'Lascaux')) {
      $id = $id->pk();
    }

    foreach ($this->items as $item) {
      if ($item->pk() == $id) {
        return $item;
      }
    }

    return false;
  }

}