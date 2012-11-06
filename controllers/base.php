<?php

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;

class Keystone_Base_Controller extends Controller {

  public $restful = true;

  public function before()
  {
    Keystone\Assetic::add('css', Bundle::path('keystone').'public/css/screen.css');
    Keystone\Assetic::add('css', Bundle::path('keystone').'public/fontawesome/css/font-awesome.css');
  }

  /**
   * Catch-all method for requests that can't be matched.
   *
   * @param  string    $method
   * @param  array     $parameters
   * @return Response
   */
  public function __call($method, $parameters)
  {
    return Response::error('404');
  }

}