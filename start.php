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
| Add Field Dirs
|--------------------------------------------------------------------------
|
*/

Keystone\Field::addDirectory(Bundle::path('keystone').'fields');
Keystone\Layout::addDirectory(Bundle::path('keystone').'layouts');

/*
|--------------------------------------------------------------------------
| Add Default View Handlers & Paths
|--------------------------------------------------------------------------
|
*/

Keystone\View::addHandler('.txt', 'Keystone\View\Renderer\Text');
Keystone\View::addHandler('.twig', 'Keystone\View\Renderer\Twig');
Keystone\View::addHandler('.php', 'Keystone\View\Renderer\Php');
Keystone\View::addDirectory('field', Bundle::path('keystone').'fields');
Keystone\View::addDirectory('view', Bundle::path('keystone').'views');
Keystone\View::addDirectory('layout', Bundle::path('keystone').'layouts');
Keystone\View::addDirectory('layout', path('app').'layouts');

/*
|--------------------------------------------------------------------------
| Extend Twig with Laravel specific methods
|--------------------------------------------------------------------------
|
*/

Keystone\View\Renderer\Twig::addFunction('ucfirst', 'ucfirst');

if (!function_exists('twig_fn_route')) {
  function twig_fn_route() {
    return Request::route()->action['as'];
  }
}

Keystone\View\Renderer\Twig::addFunction('route', 'twig_fn_route');
Keystone\View\Renderer\Twig::addFunction('url_to_route', 'URL::to_route');
Keystone\View\Renderer\Twig::addFunction('session_get', 'Session::get');
Keystone\View\Renderer\Twig::addFunction('val', 'Input::get');
Keystone\View\Renderer\Twig::addFunction('each_field_type', 'Keystone\Field::getAll');

if (!function_exists('twig_fltr_with_query_string')) {
  function twig_fltr_with_query_string($url) {
    $query = Request::foundation()->query->all();
    return $url.($query?'?'.http_build_query($query, '', '&amp;'):'');
  }
}

Keystone\View\Renderer\Twig::addFilter('with_query_string', 'twig_fltr_with_query_string');

