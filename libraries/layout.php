<?php

namespace Keystone;

require \Bundle::path('keystone').'libraries'.DS.'layout'.DS.'helper'.EXT;

class Layout {

	private static $active;
	private static $screen;
  private $name;
  private $regions = array();

	public static function all()
	{
		$layouts = array();
    $layout_dirs = \Keystone\Config::get_paths('keystone::layout.directories');
    foreach ($layout_dirs as $dir) {
      if (is_dir($dir)) {
        $layout_files = scandir($dir);
        foreach ($layout_files as $layout) {
          if (substr($layout, 0, 1) == '.') continue;
          $layouts[] = $layout;
        }
      }
    }
		return $layouts;
	}

	public static function active()
	{
		return array(static::$active, static::$screen);
	}

	public function __construct($name, $screens=array())
	{
    $this->name = $name;
    if (is_array($screens)) {
  		foreach ($screens as $screen => $regions) {
        foreach ($regions as $region => $fields) {
          $this->regions[$screen][$region] = \Keystone\Region::make()
            ->with('fields', $fields)
          ;
        }
      }
    }
	}

	public function set_active($screen)
	{
		static::$active = $this;
		static::$screen = $screen;
	}

	public function release_active()
	{
		static::$active = null;
		static::$screen = null;
	}

	public function region($name)
	{
    return array_get($this->regions, $name);
	}

  public function name()
  {
    return $this->name;
  }

  public function json()
  {
    $json = array();
    foreach ($this->regions as $screen => $regions) {
      foreach ($regions as $region_name => $region) {
        $json[$screen][$region_name] = $region->to_array();
      }
    }
    return json_encode($json);
  }

	public function form($__screen)
	{
		$this->set_active($__screen);

		$__data = array();

		$__path = false;
    foreach (\Keystone\Config::get_paths('keystone::layout.directories') as $__dir) {
      if (file_exists($__dir.$this->name.'/'.$__screen.EXT)) {
        $__path = $__dir.$this->name.'/'.$__screen.EXT;
        break;
      }
    }

    if (!$__path) {
      throw new \Exception("Could not find layout [{$this->name}/{$__screen}].");
    }

		$__contents = \File::get(realpath($__path));

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