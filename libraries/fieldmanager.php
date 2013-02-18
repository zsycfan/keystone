<?php

namespace Keystone;

/**
 * Field Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Field Manager stores and reports
 * on the available fields.
 */
class FieldManager extends Manager {

  protected $class = '\Keystone\Field';
  protected $factoryMethod = 'makeWithType';

}