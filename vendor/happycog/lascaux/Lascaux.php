<?php

use Illuminate\Support\Contracts\JsonableInterface;

class Lascaux implements JsonableInterface {

  protected $primaryKeyField = 'id';
  protected $table = null;
  private $attributes = array();
  private $relations = array();

  public static function getTable()
  {
    $obj = new static;
    return $obj->table ?: strtolower(str_plural(ltrim(rtrim(preg_replace('/([A-Z])/', '_$1', get_called_class()),'_'), '_')));
  }

  public function getPrimaryKey()
  {
    return $this->attributes[$this->getPrimaryKeyField()];
  }
  public function pk() { return $this->getPrimaryKey(); }

  public function setPrimaryKey($value) {
    $this->attributes[$this->getPrimaryKeyField()] = $value;
  }

  public function getPrimaryKeyField()
  {
    return $this->primaryKeyField;
  }

  public function hasMany($relatedClass, $key=false)
  {
    $relatedObject = new $relatedClass;
    return (object)array(
      'relatedClass' => $relatedClass,
      'relatedObject' => $relatedObject,
      'relatedTable' => $relatedObject->getTable(),
      'localKey' => 'id',
      'foreignKey' => $key ?: strtolower(str_singular(get_class($this))).'_id',
      'collection' => true,
    );
  }

  public function belongsTo($relatedClass, $key=false)
  {
    $relatedObject = new $relatedClass;
    return (object)array(
      'relatedClass' => $relatedClass,
      'relatedObject' => $relatedObject,
      'relatedTable' => $relatedObject->getTable(),
      'localKey' => $key ?: strtolower(str_singular($relatedClass)).'_id',
      'foreignKey' => 'id',
      'collection' => false,
    );
  }

  public function hasOne($relatedClass, $key=false)
  {
    $relatedObject = new $relatedClass;
    return (object)array(
      'relatedClass' => $relatedClass,
      'relatedObject' => $relatedObject,
      'relatedTable' => $relatedObject->getTable(),
      'localKey' => $key ?: strtolower(str_singular($relatedClass)).'_id',
      'foreignKey' => 'id',
      'collection' => false,
    );
  }

  public function newInstance()
  {
    return new static;
  }

  public function setRaw($input)
  {
    foreach ($input as $key => $value) {
      $this->{$key} = $value;
    }
    return $this;
  }

  public function acknowledgeRelation($key)
  {
    if (isset($this->relations[$key])) {
      return false;
    }

    $relation = $this->getRelation($key);
    if ($relation->collection === true) {
      if (!isset($this->relations[$key])) {
        $this->relations[$key] = new \Lascaux\Collection;
      }
    }
    else {
      $this->relations[$key] = null;
    }

    return true;
  }

  public function getRelation($key)
  {
    return method_exists($this, $key) ? $this->{$key}() : false;
  }

  public function addRelation($key, $value)
  {
    $this->acknowledgeRelation($key);
    $relation = $this->{$key}();
    if ($relation->collection === true) {
      if (!$this->relations[$key]->find($value->pk())) {
        $this->relations[$key]->add($value);
      }
    }
    else {
      if (!isset($this->relations[$key])) {
        $this->relations[$key] = $value;
      }
    }
  }

  public function save()
  {
    $query = new \Lascaux\Builder;
    $query->setModel($this);
    $query->insert(static::getTable());
    $query->set($this->attributes);
    $query->get();
  }

  public static function __callStatic($method, $args)
  {
    $builder = new \Lascaux\Builder;
    $builder->setModel(new static);
    $builder->from(static::getTable());
    return call_user_func_array(array($builder, $method), $args);
  }

  public function __set($key, $value)
  {
    $this->attributes[$key] = $value;
  }

  public function __get($key)
  {
    if (@$value=$this->attributes[$key]) {
      return $value;
    }
    if (@$value=$this->relations[$key]) {
      return $value;
    }
  }

  public function __toString()
  {
    return json_encode($this->attributes);
  }

  public function toArray()
  {
    return $this->attributes;
  }

  public function toJson($options=0)
  {
    $relations = array();
    foreach ($this->relations as $key => $relation) {
      $relations[$key] = $relation->toArray();
    }

    return json_encode($this->attributes + $relations);
  }

}