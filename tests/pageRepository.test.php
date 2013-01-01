<?php

// tick

class TestPageRepository extends PHPUnit_Framework_TestCase {

  // Load the bundle
  protected function setUp()
  {
    Bundle::start('keystone');
  }

  // START TESTS!

  public function testGetAllPages()
  {
    $this->assertEquals(
      'Keystone\Page\Collection',
      get_class(\Keystone\Page\Repository::findAll())
    );
  }

  public function testGetOnePage()
  {
    $this->assertEquals(
      'Keystone\Page',
      get_class(\Keystone\Page\Repository::find(1))
    );
  }

}