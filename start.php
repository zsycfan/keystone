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
| Auto-Loader Directories
|--------------------------------------------------------------------------
|
| The Laravel auto-loader can search directories for files using the PSR-0
| naming convention. This convention basically organizes classes by using
| the class namespace to indicate the directory structure.
|
*/

Autoloader::directories(array(
	Bundle::path('keystone').'models',
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

/*
|--------------------------------------------------------------------------
| Eloquent Events rollbacks
|--------------------------------------------------------------------------
|
| Attach listeners on each Eloquent's model events;
| 1. Check if current method is embed in the model
| 2. call the observer if defined in model properties
|
*/
foreach (Config::get('keystone::observer.events') as $event)
{
	Event::listen('eloquent.'.$event, function($model) use($event)
	{
		$method = Config::get('keystone::observer.prefix').$event;
		
		// havea look to the instance itself, and run method if found
		if (method_exists($model, $method) and is_callable(array($model, $method)))
		{
			$model->$method();
		}
		
		// Check is developper has defined events in class properties
		if (property_exists(get_class($model), 'observe') and array_key_exists($event, $model::$observe))
		{
			foreach ((array)$model::$observe[$event] as $name => $params)
			{
				// Check if params are presents, and setup the instance
				$class = is_int($name) ? $params : $name;
				
				// instatiate Observer with parameters
				$instance = $class::factory(is_array($params) ? $params : null);
				
				// run the method
				$instance->$event($model);
			}
		}
	});
}