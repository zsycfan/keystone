<?php

class TestView extends PHPUnit_Framework_TestCase {

  // Load the bundle
  protected function setUp()
  {
    Bundle::start('keystone');
  }

  // START TESTS!

  public function testTwig()
  {
    Keystone\View::reset();
    Keystone\View::addHandler('.twig', '\Keystone\View\Renderer\Twig');
    Keystone\View::addLayoutDirectory(Bundle::path('keystone').'tests/view.layouts');
    $this->assertEquals(
      Keystone\View::makeLayout('test-twig')->with('name', 'Mark')->render(),
      'Hello Mark.'
    );
  }

}
