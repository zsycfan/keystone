<?php

namespace Keystone;

require \Bundle::path('keystone').'libraries'.DS.'layout'.DS.'helper'.EXT;

class Layout {

	public static $active;
  private $name;
  private $page;

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
		return static::$active;
	}

	public function __construct($name, \Keystone\Entity\Page $page)
	{
		$this->name = $name;
		$this->page = $page;
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
    return @$this->page->regions->$name;
	}

  public function name()
  {
    return $this->name;
  }

	public function form()
	{
		$this->set_active();

		$__data = array();

		// The contents of each view file is cached in an array for the
		// request since partial views may be rendered inside of for
		// loops which could incur performance penalties.
    $__path = false;
    foreach (\Keystone\Config::get_paths('application::keystone.layout_directories') as $__dir) {
      if (file_exists($__dir.$this->name.'/'.$this->name.EXT)) {
        $__path = $__dir.$this->name.'/'.$this->name.EXT;
        break;
      }
    }

    if (!$__path) {
      throw new \Exception("Could not find layout [{$this->name}].");
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