<?php

namespace Keystone;

/**
 * Api Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Api Manager stores and reports
 * on the available API classes.
 */
class ApiManager extends Manager {

  protected $class = '\Keystone\Api';
  protected $factoryMethod = 'makeWithName';

}