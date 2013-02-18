<?php

use Laravel\Bundle;
use Keystone\Asset;
use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once str_finish(__DIR__, '/').'libraries/field.php';

FieldManager::register('plain')
  ->setLabel('Plain')
  ->setClass('PlainField')
  ->setPath(str_finish(__DIR__, '/').'views')
;

Asset::addCssFile(Bundle::path('keystone')."plugins/markhuot/plain/css/field.css");