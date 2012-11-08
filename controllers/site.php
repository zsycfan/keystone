<?php

class Keystone_Site_Controller extends Base_Controller
{
	
	public $restful = true;

	public function get_page($uri)
	{
    if (!$pages = Keystone\Keystone::make(array('uri' => $uri))->get_pages()) {
      return Response::error('404');
    }
	}

}