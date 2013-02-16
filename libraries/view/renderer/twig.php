<?php

namespace Keystone\View\Renderer;
use Keystone\View\Renderer;

class Twig extends Renderer
{
  private static $cache = null;
  private static $debug = true;
  private static $autoreload = true;
  private static $functions = array();
  private static $filters = array();
  private static $tags = array();

  public static function setCache($cache)
  {
    static::$cache = $cache;
  }

  public static function setDebug($debug)
  {
    static::$debug = $debug;
  }

  public static function setAutoReload($autoreload)
  {
    static::$autoreload = $autoreload;
  }

  public static function addFunction($name, $function, $params=array())
  {
    static::$functions[] = array(
      'name' => $name,
      'function' => $function,
      'params' => $params,
    );
  }

  public static function addFilter($name, $filter, $params=array())
  {
    static::$filters[] = array(
      'name' => $name,
      'filter' => $filter,
      'params' => $params,
    );
  }

  public static function addTag($class)
  {
    static::$tags[] = $class;
  }

	public function render()
	{
    // Register the Twig Autoloader.
    \Twig_Autoloader::register();

    // Build the Twig object. By default, we will add the application views folder and the
    // bundle's views folder to the Twig loader.
    $loader = new \Twig_Loader_Filesystem(array(
      $this->directory(),
      \Bundle::path('keystone').'plugins',
    ));

    // Define the Twig environment.
    $twig_env = new \Twig_Environment($loader, array(
      'cache' => static::$cache,
      'debug' => static::$debug,
      'autoreload' => static::$autoreload,
    ));

    // Register functions as Twig functions
    foreach (static::$functions as $function) {
      $twig_env->addFunction($function['name'], new \Twig_Function_Function($function['function'], $function['params']));
    }

    // Register filters as Twig filters
    foreach (static::$filters as $name => $filter) {
      $twig_env->addFilter($filter['name'], new \Twig_Filter_Function($filter['filter'], $filter['params']));
    }

    // Register tags as Twig tags
    foreach (static::$tags as $tag) {
      $twig_env->addTokenParser(new $tag);
    }

    return $twig_env->render($this->name().$this->extension(), $this->data());
	}
}