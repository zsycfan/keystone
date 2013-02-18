<?php

use Keystone\FieldManager;
use Keystone\LayoutManager;
use Keystone\Screen;

LayoutManager::register('markhuot.content')
  ->setLabel('Content')
  ->setPath(str_finish(__DIR__, '/').'layouts')
  ->addScreen(Screen::makeWithName('content', 'content.twig', 'Content'))
  ->addScreen(Screen::makeWithName('settings', 'settings.twig', 'Settings'))
;