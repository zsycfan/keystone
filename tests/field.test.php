<?php

class TestField extends PHPUnit_Framework_TestCase {

  // Load the bundle
  protected function setUp()
  {
    Bundle::start('keystone');
  }

  // START TESTS!

  public function testGetAll()
  {
    
    $this->assertTrue(
      in_array('plain', Keystone\Field::getAll())
    );
  }

}
