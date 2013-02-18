<?php

use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once \Bundle::path('keystone')."plugins/markhuot/tags/libraries/field.php";

FieldManager::register('tags')
  ->setLabel('Tags')
  ->setPath(Bundle::path('keystone').'plugins/markhuot/tags/views')
;