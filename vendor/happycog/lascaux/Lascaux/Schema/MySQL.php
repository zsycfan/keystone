<?php

namespace Lascaux\Schema;

class MySQL extends \Lascaux\Schema {

  public static function getColumnsFor($table)
  {
    $statement = $this->db->prepare('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ? and table_schema = ?');
    $statement->execute(array($table, \DB::getConfig('database')));
    $items = $statement->fetchAll(\PDO::FETCH_COLUMN);
    return $items;
  }

}