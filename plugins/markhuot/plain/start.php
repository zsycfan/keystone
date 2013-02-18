<?php

use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once \Bundle::path('keystone')."plugins/plain/libraries/field.php";

FieldManager::register('plain')
  ->setLabel('Plain')
  ->setPath(Bundle::path('keystone').'plugins/markhuot/plain/views')
;