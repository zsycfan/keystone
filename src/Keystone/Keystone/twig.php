<?php

namespace Keystone\Keystone;


class Twig
{
  private static $loader = null;
  private static $environment = null;
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

  public static function getEnvironment()
  {
    if (!static::$environment) {
      static::$environment = new \Twig_Environment(static::getLoader(), array(
        'cache' => static::$cache,
        'debug' => static::$debug,
        'autoreload' => static::$autoreload,
      ));
    }

    return static::$environment;
  }

  public static function addFunction($func)
  {
    return static::getEnvironment()->addFunction($func);
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

  public static function addPath($path, $namespace = '__main__')
  {
    static::getLoader()->addPath($path, $namespace);
  }

  public static function getLoader()
  {
    if (!static::$loader) {
      static::$loader = new \Twig_Loader_Filesystem(array());
    }

    return static::$loader;
  }

	public static function render($template, $data=array())
	{
    // Register the Twig Autoloader.
    \Twig_Autoloader::register();

    // Define the Twig environment.
    $twig = static::getEnvironment();

    // Register functions as Twig functions
    // foreach (static::$functions as $function) {
    //   $twig->addFunction($function['name'], new \Twig_Function_Function($function['function'], $function['params']));
    // }

    // // Register filters as Twig filters
    // foreach (static::$filters as $name => $filter) {
    //   $twig->addFilter($filter['name'], new \Twig_Filter_Function($filter['filter'], $filter['params']));
    // }

    // // Register tags as Twig tags
    // foreach (static::$tags as $tag) {
    //   $twig->addTokenParser(new $tag);
    // }

    $twig->addTokenParser(new Region_TokenParser());

    return $twig->render($template, $data);
	}
}



class Region_TokenParser extends \Twig_TokenParser
{
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();

        $name = $this->parser->getExpressionParser()->parseExpression();
        // $this->parser->getStream()->expect(\Twig_Token::PUNCTUATION_TYPE);
        // $args = array();
        // while(!$this->parser->getStream()->test(\Twig_Token::BLOCK_END_TYPE)) {
        //   $args[] = $this->parser->getExpressionParser()->parseExpression();
        //   if ($this->parser->getStream()->test(\Twig_Token::PUNCTUATION_TYPE)) {
        //     $this->parser->getStream()->next();
        //   }
        // }
        // print_r($args); die;
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        $template = new \Twig_Node_Expression_Constant("content/_region.twig", $lineno);
        return new Region_Node($name, $template, null, false, false, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'region';
    }
}

class Region_Node extends \Twig_Node_Include
{
  private $name;

  public function __construct($name, \Twig_Node_Expression $expr, \Twig_Node_Expression $variables = null, $only = false, $ignoreMissing = false, $lineno, $tag = null)
  {
    $this->name = $name;
    parent::__construct($expr, $variables, $only, $ignoreMissing, $lineno, $tag);
  }

  public function compile(\Twig_Compiler $compiler)
  {
    $compiler
      ->addDebugInfo($this)
      ->write('$context[\'region\'] = $context[\'layout\']->getRegion(\''.$this->name->getAttribute('value').'\')')
      ->raw(";\n")
    ;
    parent::compile($compiler);
  }
}