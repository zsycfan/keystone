<?php

function region($params) {
  list($layout, $screen) = \Keystone\Layout::active();
	return \Keystone\Region::make($params)
	  ->with('fields', $layout->region("{$screen}.{$params['name']}"))
	  ->form()
	;
}