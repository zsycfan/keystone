<?php

namespace Keystone;

class Region {

	public $name;
	public $empty = true;
	public $max = null;
	public $min = null;
	private $data;

	public function __construct($params, $data = array())
	{
		foreach ($params as $k => $v) {
			switch ($k) {
				case 'allow':
					if (!is_array($v)) { $v = array($v); }
					break;
			}
			$this->$k = $v;
		}
		$this->data = $data;
	}

	public function __toString()
	{
		return (string)\Laravel\View::make('keystone::region.edit')
			->with('region', $this)
			->with('data', $this->data)
		;
	}

}