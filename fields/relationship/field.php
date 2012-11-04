<?php

class Relationship_Field
{
	public function get($data) {
		if ($data['related']) {
			$data['related'] = Page::find($data['related'])->latest_revision()->to_array();
		}
		return $data;
	}
}