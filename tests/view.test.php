<?php

class TestView extends PHPUnit_Framework_TestCase {

  // Load the bundle
  protected function setUp()
  {
    Bundle::start('keystone');
  }

  // START TESTS!

  /* public function testSettingRegionsToString()
  {
	Keystone\View::addHandler('.txt', '\Keystone\View\Renderer\Text');
	Keystone\View::addDirectory('layout', '/home/markhuot/www/bundles/keystone/tests/layouts');
	echo Keystone\View::makeLayout('test')->render();
  } */

  public function testTwig()
  {
	Keystone\View::reset();
	Keystone\View::addHandler('.twig', '\Keystone\View\Renderer\Twig');
	Keystone\View::addDirectory('layout', Bundle::path('keystone').'tests/layouts');
	$this->assertEquals(
	  Keystone\View::makeLayout('test')->with('name', 'Mark')->render(),
	  'Hello Mark.'
    );
  }

}
