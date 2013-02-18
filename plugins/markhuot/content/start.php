<?php

use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

require_once \Bundle::path('keystone')."plugins/plain/libraries/field.php";

LayoutManager::register('markhuot.content')
  ->setLabel('Content')
  ->setPath(Bundle::path('keystone').'plugins/markhuot/content/layouts')
  ->addScreen(Screen::makeWithName('content', 'content.twig', 'Content'))
  ->addScreen(Screen::makeWithName('settings', 'settings.twig', 'Settings'))
;

FieldManager::register('plain')
  ->setLabel('Plain')
  ->setPath(Bundle::path('keystone').'plugins/markhuot/plain/views')
  ->setClass('PlainField')
;