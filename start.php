<?php

/*
|--------------------------------------------------------------------------
| Set Mimes
|--------------------------------------------------------------------------
|
| The default mimes list is missing a few, so we'll augment it here unitl
| our pull request is merged into the core
|
*/
Config::set('application::mimes', Config::get('keystone::mimes'));

/*
|--------------------------------------------------------------------------
| Auto-Loader Mappings
|--------------------------------------------------------------------------
|
| Registering a mapping couldn't be easier. Just pass an array of class
| to path maps into the "map" function of Autoloader. Then, when you
| want to use that class, just use it. It's simple!
|
*/

Autoloader::map(array(
	'Keystone_Base_Controller' => Bundle::path('keystone').'controllers/base.php',
));

/*
|--------------------------------------------------------------------------
| Auto-Loader Namespaces
|--------------------------------------------------------------------------
|
*/

Autoloader::namespaces(array(
	'Keystone' => Bundle::path('keystone').'libraries',
));

/*
|--------------------------------------------------------------------------
| Auto-Loader Composer
|--------------------------------------------------------------------------
|
*/

require_once Bundle::path('keystone').'vendor'.DS.'autoload'.EXT;

// --------------------------------------------------------------
// The path to the layouts directory.
// --------------------------------------------------------------
$GLOBALS['laravel_paths']['layouts'] = Bundle::path('keystone').'layouts'.DS;

// --------------------------------------------------------------
// The path to the fields directory.
// --------------------------------------------------------------
$GLOBALS['laravel_paths']['fields'] = Bundle::path('keystone').'fields'.DS;