<?php

namespace Keystone\Keystone;

/**
 * Screen Manager
 * ====
 *
 * Like most `Manager` classes in Keystone the Screen Manager stores and reports
 * on the available layouts.
 */
class ScreenManager extends Manager {

  protected $class = '\Keystone\Keystone\Screen';
  protected $factoryMethod = 'makeWithName';

}