<?php

use Laravel\Bundle;
use Keystone\Asset;
use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once Bundle::path('keystone')."plugins/markhuot/plain/libraries/field.php";

FieldManager::register('plain')
  ->setLabel('Plain')
  ->setClass('PlainField')
  ->setPath(Bundle::path('keystone').'plugins/markhuot/plain/views')
;

Asset::addCssFile(Bundle::path('keystone')."plugins/markhuot/plain/css/field.css");