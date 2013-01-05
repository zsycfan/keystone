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

require Bundle::path('keystone').'vendor'.DS.'autoload'.EXT;

/*
|--------------------------------------------------------------------------
| Add Default View Handlers & Paths
|--------------------------------------------------------------------------
|
*/
Keystone\View::addHandler('.txt', 'Keystone\View\Renderer\Text');
Keystone\View::addHandler('.twig', 'Keystone\View\Renderer\Twig');
Keystone\View::addHandler('.php', 'Keystone\View\Renderer\Php');
Keystone\View::addDirectory('view', Bundle::path('keystone').'views');
Keystone\View::addDirectory('layout', Bundle::path('keystone').'layouts');
Keystone\View::addDirectory('layout', path('app').'layouts');