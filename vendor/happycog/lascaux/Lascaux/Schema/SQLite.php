<?php

namespace Lascaux\Schema;

class SQLite extends \Lascaux\Schema {

  public function getColumnsFor($table)
  {
    return array_reduce(
      $this->db->query("PRAGMA table_info(`$table`)")->fetchAll(),
      function($rV,$cV) { $rV[]=$cV['name']; return $rV; },
      array()
    );
  }

}