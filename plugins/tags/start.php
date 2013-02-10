<?php

Autoloader::namespaces(array(
  'Tags' => Bundle::path('keystone').'plugins/tags',
));

\Keystone\Field::register('tags', "\Keystone\Fields\Tags\Field");