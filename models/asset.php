<?php

class Asset extends Articulate
{

	public static function create($asset)
	{
		$path = $asset['path'].$asset['name'];

		if ($image = @getimagesize($path)) {
			if (!isset($asset['width'])) {
				$asset['width'] = $image[0];
			}

			if (!isset($asset['height'])) {
				$asset['height'] = $image[1];
			}

			if (!isset($asset['mime'])) {
				$asset['mime'] = $image['mime'];
			}
		}

		if (!isset($asset['filesize'])) {
			$asset['filesize'] = File::size($path);
		}

		if (!isset($asset['type'])) {
			$asset['type'] = File::type($path);
		}

		if (!isset($asset['mime'])) {
			$asset['mime'] = File::mime($path);
		}

		return parent::create($asset);
	}

}