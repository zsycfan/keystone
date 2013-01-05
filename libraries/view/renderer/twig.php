<?php

namespace Keystone\View\Renderer;
use Keystone\View\Renderer;

class Twig extends Renderer
{
	public function render()
	{
    // Grab our config file
    // $config = require __DIR__.'/Twig/config.php';

    // Include the Twig functions we wish to register.
    /* foreach ($config['include'] as $file)
    {
      require_once $file;
    } */

    // Register the Twig Autoloader.
    \Twig_Autoloader::register();

    // Build the Twig object. By default, we will add the application views folder and the
    // bundle's views folder to the Twig loader.
    $loader = new \Twig_Loader_Filesystem(array(
      $this->directory()
    ));

    // Load the Twig_Environment configuration.
    $cache = @$config['cache'] ?: null;
    $debug = @$config['debug'] ?: true;
    $autoreload = @$config['autoreload'] ?: true;
    $functions = @$config['functions'] ?: array();
    $filters = @$config['filters'] ?: array();
    $tags = @$config['tags'] ?: array();

    // Define the Twig environment.
    $twig_env = new \Twig_Environment($loader, array(
      'cache' => $cache,
      'debug' => $debug,
      'autoreload' => $autoreload,
    ));

    // Register functions as Twig functions
    foreach ($functions as $name => $value) {
      $params = isset($value['params']) ? $value['params'] : array();
      $twig_env->addFunction($name, new \Twig_Function_Function($value['function'], $params));
    }

    // Register filters as Twig filters
    foreach ($filters as $name => $value) {
      $params = isset($value['params']) ? $value['params'] : array();
      $twig_env->addFilter($name, new \Twig_Filter_Function($value['filter'], $params));
    }

    // Register tags as Twig tags
    foreach ($tags as $name) {
      $twig_env->addTokenParser(new $name);
    }

    return $twig_env->render($this->name().$this->extension(), $this->data());
	}
}