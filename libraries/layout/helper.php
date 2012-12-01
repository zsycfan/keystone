<?php

function region($params) {
  $params['fields'] = \Keystone\Layout::active()->region($params['name']);
	$region = new \Keystone\Region($params);
  return $region->form();
}