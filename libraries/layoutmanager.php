<?php

namespace Keystone;

/**
 * Layout Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Layout Manager stores and reports
 * on the available layouts.
 */
class LayoutManager extends Manager {

  protected $class = '\Keystone\Layout';
  protected $factoryMethod = 'makeWithName';

}