<?php

class TestRegion extends PHPUnit_Framework_TestCase {

  public function testSettingAllowToString()
  {
    Bundle::start('keystone');
    $region = new \Keystone\Region(array('allow' => 'plain'));
    $this->assertEquals($region->allow, array('plain'));
  }

}