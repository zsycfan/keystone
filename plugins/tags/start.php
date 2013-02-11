<?php

Autoloader::namespaces(array(
  'Tags' => Bundle::path('keystone').'plugins/tags',
));

\Keystone\FieldManager::register('tags', "\Keystone\Fields\Tags\Field");