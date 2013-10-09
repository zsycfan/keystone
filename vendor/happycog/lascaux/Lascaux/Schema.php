<?php

namespace Lascaux;

abstract class Schema {

  protected $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

}