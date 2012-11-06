<?php

class Keystone_Fields_Controller extends Keystone_Base_Controller {

	public function get_css()
	{
		return Response::make(Keystone\Field::css());
	}

	public function get_js()
	{
		return Response::make(Keystone\Field::javascript());
	}

}