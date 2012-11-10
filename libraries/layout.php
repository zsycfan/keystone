<?php

namespace Keystone;

require \Bundle::path('keystone').'libraries'.DS.'layout'.DS.'helper'.EXT;

class Layout {

	public static $active;
  private $name;
  private $regions;

	public static function all()
	{
		$layouts = array();
		$layout_files = scandir(path('layouts'));
		foreach ($layout_files as $layout) {
			if (substr($layout, 0, 1) == '.') continue;
			$layouts[] = $layout;
		}
		return $layouts;
	}

	public static function active()
	{
		return static::$active;
	}

	public function __construct($name, $regions=array())
	{
		$this->name = $name;
		$this->regions = $regions;
	}

	public function set_active()
	{
		static::$active = $this;
	}

	public function release_active()
	{
		static::$active = null;
	}

	public function get_region_data($name)
	{
		return @$this->regions[$name];
	}

	public function form()
	{
		$this->set_active();

		$__data = array();

		// The contents of each view file is cached in an array for the
		// request since partial views may be rendered inside of for
		// loops which could incur performance penalties.
		$__contents = \File::get(realpath(path('layouts').$this->name.'/'.$this->name.'.php'));

		ob_start() and extract($__data, EXTR_SKIP);

		// We'll include the view contents for parsing within a catcher
		// so we can avoid any WSOD errors. If an exception occurs we
		// will throw it out to the exception handler.
		try
		{
			eval('?>'.$__contents);
		}

		// If we caught an exception, we'll silently flush the output
		// buffer so that no partially rendered views get thrown out
		// to the client and confuse the user with junk.
		catch (\Exception $e)
		{
			ob_get_clean(); throw $e;
		}

		$content = ob_get_clean();

		$this->release_active();

		return $content;
	}

}