<?php

// Setup our IoC Containers
App::singleton('mongo', function()
{
  return new MongoClient("mongodb://localhost");
});
App::singleton('db', function()
{
  return App::make('mongo')->keystone;
});

// Setup Twig
Keystone\Keystone\Twig::addPath(keystonePath('src/views'));
Keystone\Keystone\Twig::addFunction(new Twig_SimpleFunction('url_to', 'URL::to'));

// Add a function for easy path management
function keystonePath($path) {
  return str_finish(realpath(__DIR__.'/../'), '/').$path;
}

// Start our plugins
$plugins = File::glob(base_path().'/plugins/*');
foreach ($plugins as $plugin) {
  if (is_file($start=str_finish($plugin, '/').'start.php')) {
    require_once $start;
  }
}