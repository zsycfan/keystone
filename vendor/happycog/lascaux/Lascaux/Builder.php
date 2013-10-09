<?php

namespace Lascaux;

class Builder {

  private $db;
  private $schema;
  private $model;

  private $table;
  private $where = array();
  private $rawWhere = '';
  private $arguments = array();
  private $limit = null;
  private $join = array();
  private $set = array();
  private $insert = false;

  public function __construct()
  {
    list($this->db, $this->schema) = Connection::connect();
  }

  public function getPdo()
  {
    return $this->db;
  }

  public function setModel($model)
  {
    $this->model = $model;
    return $this;
  }

  public function insert($table)
  {
    $this->insert = true;
    $this->table = $table;
    return $this;
  }

  public function from($table)
  {
    $this->table = $table;
    return $this;
  }

  public function join($table, $left, $op, $right, $type='inner', $alias=false)
  {
    $alias = $alias ?: $table;
    $this->join[$alias] = array(
      'type' => $type,
      'table' => $table,
      'left' => $left,
      'op' => $op,
      'right' => $right,
      'alias' => $alias,
    );
    ksort($this->join);
    return $this;
  }

  public function with($relations)
  {
    foreach (func_get_args() as $relation) {
      $model = $this->model;
      $models = preg_split('/\./', $relation);
      foreach ($models as $alias) {
        if (method_exists($model, $alias)) {
          $obj = $model->getRelation($alias);
          $this->join($obj->relatedTable, $obj->relatedObject->getTable().'.'.$obj->foreignKey, '=', $model->getTable().'.'.$obj->localKey, 'left', $relation);
          $model = $obj->relatedObject;
        }
        else {
          throw new \Exception('Unknown relationship `'.$alias.'` on '.get_class($model).' model.');
        }
      }
    }

    return $this;
  }

  public function where($key, $op='=', $value=null)
  {
    list($key, $op, $value) = $this->parseStatement($key, $op, $value);
    $this->where[$key] = array('op'=>$op, 'value'=>$value);
    return $this;
  }

  public function predicate($where, $args=false)
  {
    if (!is_array($args)) {
      $args = func_get_args();
      array_shift($args);
      $args = array_merge($args);
    }
    preg_match_all('/([\w.]+)\s*(=|==|IN|<=|<|>|>=)\s*(\:?\w+|\?)/', $where, $matches);
    foreach ($matches[0] as $index => $match) {
      list($key, $op, $value) = $this->parseStatement($matches[1][$index], $matches[2][$index], $matches[3][$index]);
      $where = str_replace($match, "{$key} {$op} {$value}", $where);
      $this->addArgument($value, $args[$value=='?'?$index:$value]);
    }
    $this->rawWhere = $where;
    return $this;
  }

  public function parseStatement($key, $op, $value)
  {
    if ($this->model && method_exists($this->model, $key)) {
      $key = $key.'.'.$this->model->getRelation($key)->foreignKey;
    }
    
    if ($this->model && strpos($key, '.') !== false) {
      $models = preg_split('/\./', $key);
      $key = array_pop($models);
      foreach ($models as $alias) {
        $obj = $this->model->getRelation($alias);
        $this->with(implode('.', $models));
        $key = "{$obj->relatedTable}.{$key}";
      }
    }

    return array($key, $op, $value);
  }

  public function set($key, $value=false)
  {
    if (func_num_args() == 1) {
      foreach ($key as $k => $v) {
        $this->set($k, $v);
      }
      return $this;
    }

    $this->set[$key] = $value;
  }

  public function limit($limit)
  {
    $this->limit = $limit;
    return $this;
  }

  public function all()
  {
    return $this->get();
  }

  public function first()
  {
    if (empty($this->join)) {
      $this->limit(1);
    }
    $items = $this->get();
    return @$items[0];
  }

  public function find($id)
  {
    $this->where(@$this->model->getPrimaryKeyField()?:'id', '=', $id);
    $this->limit(1);
    return $this->get();
  }

  public function get()
  {
    return $this->execute($this->buildQuery());
  }
  public function run() { return $this->get(); }

  public function buildQuery()
  {
    if ($this->insert) {
      $sql = 'insert into '.$this->table;
    }
    else {
      $sql = 'select ';
      $fields = array();
      $columns = $this->schema->getColumnsFor($this->table);
      foreach ($columns as $index => $column) {
        $fields[] = $this->table.'.'.$column.' AS `'.$this->table.'__'.$column.'`';
      }
      foreach ($this->join as $join) {
        $columns = $this->schema->getColumnsFor($join['table']);
        foreach ($columns as $index => $column) {
          $fields[] = $join['table'].'.'.$column.' AS `'.$join['alias'].'__'.$column.'`';
        }
      }
      $sql.= implode(',', $fields) ?: '*';
      $sql.= ' from '.$this->table;
    }
    if ($this->join) {
      foreach ($this->join as $join) {
        $sql.= ' '.$join['type'].' join '.$join['table'].' on '.$join['left'].' '.$join['op'].' '.$join['right'];
      }
    }
    if ($this->where) {
      $sql.= ' where ';
      foreach ($this->where as $key => $value) {
        $sql.= $key.' '.$value['op'].' :'.$key;
        $this->addArgument(':'.$key, $value['value']);
      }
    }
    if ($this->where && $this->rawWhere) {
      $sql.= ' and ';
    }
    else if ($this->rawWhere) {
      $sql.=  ' where ';
    }
    if ($this->rawWhere) {
      $sql.= $this->rawWhere;
    }
    if (!empty($this->set)) {
      $sql.= '('.implode(',', array_keys($this->set)).')VALUES('.implode(',', array_map(function($k){return ":{$k}";}, array_keys($this->set))).')';
      foreach ($this->set as $key => $value) {
        $this->addArgument(":{$key}", $value);
      }
    }
    if ($this->limit) {
      $sql.= ' limit '.$this->limit;
    }
    $sql.= ';';
    // echo($sql); echo "\r\n"; die;
    return $sql;
  }

  public function addArgument($key, $value)
  {
    if (is_subclass_of($value, 'Lascaux')) {
      $value = $value->getPrimaryKey();
    }
    
    if ($key === '?') {
      $this->arguments[] = $value;
    }
    else {
      $this->arguments[$key] = $value;
    }

    return $this;
  }

  public function getArguments()
  {
    return $this->arguments;
  }

  public function execute($query)
  {
    $statement = $this->db->prepare($query);
    $statement->execute($this->getArguments());
    if ($this->insert) {
      return $this->executeInsert($statement);
    }
    else {
      return $this->executeFetch($statement);
    }
  }

  public function executeInsert($statement)
  {
    $this->model->setPrimaryKey($this->db->lastInsertId());
    return $this->model;
  }

  public function executeFetch($statement)
  {
    $collection = new Collection;

    while ($row=$statement->fetch(\PDO::FETCH_ASSOC)) {
      $objects = $this->splitFieldArray($row);
      $models = $this->objectArrayToModels($objects);

      $primaryModel = array_shift($models);
      $primaryModel = $collection->add($primaryModel);

      foreach ($models as $primaryAlias => $model) {
        $aliases = preg_split('/\./', $primaryAlias);
        $key = array_pop($aliases);
        $parent = $primaryModel;

        for ($index=0; $size=count($aliases),$index<$size; $index++) {
          $alias = $aliases[$index];
          $aliasPath = array_slice($aliases, 0, $index+1);
          $parentKey = $models[implode('.',$aliasPath)]->pk();

          if (is_a($parent->{$alias}, 'Lascaux\Collection')) {
            $parent = $parent->{$alias}->find($parentKey);
          }
          else {
            $parent = $parent->{$alias};

          }
        }
        $parent->addRelation($key, $model);
      }
    }

    return $collection;
  }

  public function splitFieldArray($fields)
  {
    $objects = array();

    foreach ($fields as $field => $value) {
      preg_match('/^(.*)__/', $field, $matches);
      $namespace = $matches[1];
      $field = str_replace($matches[0], '', $field);
      $objects[$namespace][$field] = $value;
    }

    return $objects;
  }

  public function objectArrayToModels($objects)
  {
    $models = array();

    // The first object is always our primary object. So, we'll shift this off,
    // leaving us an array of related objects
    list($alias, $object) = array_kshift($objects);
    $newObj = $this->model->newInstance();
    $newObj->setRaw($object);
    $models[$alias] = $newObj;

    // Now loop over the related objects creating models for each.
    foreach ($objects as $path => $object) {

      // Each loop we'll reset our context and start looking for relationships
      // from the base model.
      $parent = $this->model;

      // Each related object could be infinitely nested, so split on our
      // delimiter and loop over each nested relation one at a time.
      $aliases = preg_split('/\./', $path);
      $alias = array_pop($aliases);
      foreach ($aliases as $aliasSegment) {
        if (method_exists($parent, $aliasSegment)) {
          $parent = $parent->getRelation($aliasSegment)->relatedObject;
        }
        else {
          throw new \Exception('Unknown relationship `'.$aliasSegment.'` on '.get_class($parent).' model.');
        }
      }
      $newObj = $parent->getRelation($alias)->relatedObject->newInstance()->setRaw($object);
      $models[$path] = $newObj;
    }

    return $models;
  }
}


function array_kshift(&$arr)
{
  list($k) = array_keys($arr);
  $r = array($k, $arr[$k]);
  unset($arr[$k]);
  return $r;
}