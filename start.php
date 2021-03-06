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
  'Plugins' => Bundle::path('keystone').'plugins',
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
| Add Directory Mappings
|--------------------------------------------------------------------------
|
*/

Keystone\FileManager::addViewDirectory(Bundle::path('keystone').'views');
Keystone\FileManager::addPluginDirectory(Bundle::path('keystone').'plugins');

/*
|--------------------------------------------------------------------------
| Start Plugins
|--------------------------------------------------------------------------
|
*/

Keystone\Plugin::start();

/*
|--------------------------------------------------------------------------
| Add Default View Handlers
|--------------------------------------------------------------------------
|
*/

Keystone\View::addHandler('.txt', 'Keystone\View\Renderer\Text');
Keystone\View::addHandler('.twig', 'Keystone\View\Renderer\Twig');
Keystone\View::addHandler('.php', 'Keystone\View\Renderer\Php');

/*
|--------------------------------------------------------------------------
| Extend Twig with Laravel specific methods
|--------------------------------------------------------------------------
|
*/

Keystone\View\Renderer\Twig::addPath(Bundle::path('keystone').'views');

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
Keystone\View\Renderer\Twig::addFunction('css_assets', 'Keystone\Asset::getCss');
Keystone\View\Renderer\Twig::addFunction('javascript_assets', 'Keystone\Asset::getJavascript');

if (!function_exists('twig_fltr_with_query_string')) {
  function twig_fltr_with_query_string($url) {
    $query = Request::foundation()->query->all();
    return $url.($query?'?'.http_build_query($query, '', '&amp;'):'');
  }
}

Keystone\View\Renderer\Twig::addFilter('with_query_string', 'twig_fltr_with_query_string');

if (!function_exists('twig_fltr_json_encode')) {
  function twig_fltr_json_encode($object) {
    if (!$object) { return ''; }
    return json_encode($object);
  }
}
Keystone\View\Renderer\Twig::addFilter('json', 'twig_fltr_json_encode');

if (!function_exists('twig_fltr_html_encode')) {
  function twig_fltr_html_encode($context, $object, $name=null) {
    $html = '';
    if (is_array($object) || is_object($object)) {
      foreach ($object as $key => $value) {
        if (is_array($value)) {
          $html.= twig_fltr_html_encode($context, $value, $key);
        }
        else {
          $html.= '<input type="hidden" name="'.$name.'['.$key.']" value="'.$value.'" />';
        }
      }
    }
    return $html;
  }
}
Keystone\View\Renderer\Twig::addFilter('html', 'twig_fltr_html_encode', array('needs_context' => true, 'is_safe' => array('html')));