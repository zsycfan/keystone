<?php

namespace Keystone;

require \Bundle::path('keystone').'libraries'.DS.'layout'.DS.'helper'.EXT;

class Layout extends Object {

	private static $active;
	private static $screen;
  private $name = null;
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

	public function __construct($name=null, $regions=array())
	{
    $this->name = $name;
    $this->update_regions($regions);
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
	
	public function set_region($name, $region)
	{
	  array_set($this->regions, $name, $region);
	}

  public function update_regions($regions)
  {
    foreach ($regions as $region_name => $region_data) {
      $this->set_region($region_name, new \Keystone\Region($region_data));
    }
  }

  public function name()
  {
    return $this->name;
  }
  
  public function set_name($name)
  {
    $this->name = $name;
  }

  public function json()
  {
    $json = array();
    foreach ($this->regions as $region_name => $region) {
      $json[$region_name] = $region->to_array();
    }
    return json_encode($json);
  }

  public static function path($name)
  {
    $components = preg_split('/\./', $name);
    if (count($components) < 1) {
      $components = array_unshift($components, 'content');
    }

    foreach (\Keystone\Config::get_paths('keystone::layout.directories') as $dir) {
      if (file_exists($path = $dir.$components[0].'/'.$components[1].EXT)) {
        return $path;
      }
    }

    return \Bundle::path('keystone').'layouts/content/'.$components[1].EXT;
  }

	public function form($__screen='content')
	{
		$this->set_active($__screen);

		$__data = array();

		$__path = static::path("{$this->name}.{$__screen}");

    if (!is_file($__path)) {
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