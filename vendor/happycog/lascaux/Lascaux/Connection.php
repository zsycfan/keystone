<?php

namespace Lascaux;

class Connection {

  public static function connect()
  {
    if (list($db, $schema)=static::connectWithLaravel()) {
      $db;
    }
    else {
      list($db, $schema) = static::connectToLocal();
    }

    return array($db, $schema);
  }

  public static function connectWithLaravel()
  {
    if (!class_exists('DB') || !method_exists('DB', 'getConfig')) {
      return false;
    }

    $db = new \PDO('mysql:host='.\DB::getConfig('host').';dbname='.\DB::getConfig('database'), 'root', 'root', array());
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return array($db, new Schema\MySQL($db));
  }

  public static function connectToLocal()
  {
    $db = new \PDO('sqlite:./test.sql');
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return array($db, new Schema\SQLite($db));
  }

}