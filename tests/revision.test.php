<?php

class TestNewRevision extends PHPUnit_Framework_TestCase {

  public function testEmptyRegionIsNullNotEmptyArrayOrEmptyObject()
  {
    Bundle::start('keystone');
    $page = new \Keystone\Entity\Page();
    $this->assertEquals($page->regions->json(), null);
  }

}