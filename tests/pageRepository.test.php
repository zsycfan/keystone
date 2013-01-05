<?php

// tick

class TestPageRepository extends PHPUnit_Framework_TestCase {

  // Load the bundle
  protected function setUp()
  {
    Bundle::start('keystone');
    Session::load('file');
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

  public function testCreatedDateTimezone()
  {
    $page = \Keystone\Page::make()
      ->with('createdAt', new DateTime('2012-11-15 00:00:00 -5:00'))
    ;

    $this->assertEquals(
      $page->createdAt->getOffset(),
      -18000
    );
  }

  public function testCreatedDate()
  {
    $page = \Keystone\Page::make()
      ->with('createdAt', new DateTime('2012-11-15 00:00:00'))
    ;

    $this->assertEquals(
      $page->createdAt->format('r'),
      'Thu, 15 Nov 2012 00:00:00 +0000'
    );
  }

}