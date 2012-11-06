<?php

namespace Keystone;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;

class Assetic
{

	public static $assets = array();

	public static function add($type, $path)
	{
		if (!isset(static::$assets[$type])) {
			static::$assets[$type] = new AssetCollection();
		}

		static::$assets[$type]->add(new FileAsset($path));
	}

	public static function get($type)
	{
		if (isset(static::$assets[$type])) {
			return static::$assets[$type]->dump();
		}

		return false;
	}

}