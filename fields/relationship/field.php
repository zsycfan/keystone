<?php

class Relationship_Field
{
	public function get($data) {
    if ($data['related']) {
      if ($related = Keystone\Repository\Page::find($data['related'])) {
       	$data['related'] = $related->to_array();
			}
		}
		return $data;
	}
}