<?php

class Fields_Controller extends Base_Controller {

	public function get_css()
	{
		return Response::make(Field::css());
	}

	public function get_js()
	{
		return Response::make(Field::javascript());
	}

}