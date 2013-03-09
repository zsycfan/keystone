<?php

App::singleton('mongo', function()
{
  return new MongoClient("mongodb://localhost");
});

App::singleton('db', function()
{
  return App::make('mongo')->keystone;
});

App::singleton('twig', function()
{
  $loader = new Twig_Loader_Filesystem(keystonePath('src/views'));
  $twig = new Twig_Environment($loader, array(
      'cache' => app_path().'storage/views',
      'auto_reload' => true,
  ));
  $twig->addFunction(new Twig_SimpleFunction('url_to', 'URL::to'));
  return $twig;
});

function keystonePath($path) {
  return str_finish(realpath(__DIR__.'/../'), '/').$path;
}