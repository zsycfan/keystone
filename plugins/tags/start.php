<?php

use Keystone\ApiManager;
use Keystone\Asset;
use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once str_finish(__DIR__,'/').'libraries/field.php';
require_once str_finish(__DIR__,'/').'libraries/api.php';

FieldManager::register('tags')
  ->setLabel('Tags')
  ->setClass('TagsField')
  ->setPath(str_finish(__DIR__, '/').'views')
;

Asset::addCssFile(str_finish(__DIR__, '/').'css/field.css');
Asset::addJavascriptFile(str_finish(__DIR__, '/').'javascript/field.js');

ApiManager::register('tags')
  ->setClass('TagsApi')
;