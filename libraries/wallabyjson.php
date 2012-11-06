<?php

namespace Keystone;

class WallabyJson
{

	public static function content($arr)
	{
		$str = array();

		foreach ($arr as $key => $value) {
			if (is_array($value)) {
				$str[] = static::content($value);
			}
			else if (is_string($value) && $key === 'content') {
				$str[] = $value;
			}
		}
		
		return implode(' ', $str);
	}

}