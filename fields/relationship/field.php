<?php

class Relationship_Field
{
	public function get($data) {
		if ($data['related']) {
			if ($related = Keystone\Page::find($data['related'])) {
				$data['related'] = $related->latest_revision()->to_array();
			}
		}
		return $data;
	}
}