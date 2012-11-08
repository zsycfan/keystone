<?php

class Keystone_Fields_Controller extends Keystone_Base_Controller {

	public function get_css()
	{
		return Response::make(Keystone\Field::css(), 200, array(
      'Content-Type' => File::mime('css'),
    ));
	}

	public function get_js()
	{
		return Response::make(Keystone\Field::javascript(), 200, array(
      'Content-Type' => File::mime('js'),
    ));
	}

}