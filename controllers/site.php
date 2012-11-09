<?php

class Keystone_Site_Controller extends Base_Controller
{
	
	public $restful = true;

	public function get_page($uri)
	{
    try {
      $page = Keystone\Repository\Page::find_by_uri($uri, array('published' => true));
    }
    catch (Exception $e) {
      return Response::error('404');
    }
	}

}