<?php

use Keystone\Asset;
use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once str_finish(__DIR__,'/').'libraries/field.php';

FieldManager::register('tags')
  ->setLabel('Tags')
  ->setPath(str_finish(__DIR__, '/').'views')
;

Asset::addCssFile(str_finish(__DIR__, '/').'css/field.css');
Asset::addJavascriptFile(str_finish(__DIR__, '/').'javascript/field.js');