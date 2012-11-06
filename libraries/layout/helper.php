<?php

function region($params) {
	return new \Keystone\Region($params, \Keystone\Layout::active()->get_region_data($params['name']));
}