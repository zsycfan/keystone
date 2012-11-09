<?php

function region($params) {
  $params['fields'] = \Keystone\Layout::active()->get_region_data($params['name']);
	$region = new \Keystone\Region($params);
  return $region->form();
}