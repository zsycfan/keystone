<?php

// tick

class TestPage extends PHPUnit_Framework_TestCase {

  // Get text data from the expects folder so we're not placing expected HTML
  // inline with our PHP
  private function expects($name) {
    return file_get_contents(
      Bundle::path('keystone').
      'tests/page.expects/'.$name.'.txt'
    );
  }

  // Load the bundle
  protected function setUp()
  {
    Bundle::start('keystone');
  }

  // START TESTS!

  public function testSettingRegionsToString()
  {
    try {
      $page = \Keystone\Page::make();
      $page->regions = 'test';
    }
    catch (Exception $e) {
      return;
    }

    $this->fail('Invalid Argument denied.');
  }

  public function testSettingUndefinedVar()
  {
    try {
      $page = \Keystone\Page::make();
      $page->regions = array();
    }
    catch (Exception $e) {
      return;
    }
    $this->fail('Incorrectly set an undefined variable.');
  }

  public function testSettingLayoutToString()
  {
    Bundle::start('keystone');

    try {
      $page = \Keystone\Page::make();
      $page->layout = 'test';
    }
    catch (Exception $e) {
      return;
    }

    $this->fail('Invalid Argument denied.');
  }

  public function testSettingLayoutToObject()
  {
    Bundle::start('keystone');

    try {
      $page = \Keystone\Page::make();
      $page->layout = \Keystone\Layout::makeWithName('home');
    }
    catch (Exception $e) {
      $this->fail('Invalid Argument denied.');
    }
  }

  public function testFieldType()
  {
    $field = \Keystone\Field::makeWithType('plain');

    $this->assertEquals(
      'Keystone\Field', 
      get_class($field)
    );
  }

  public function testFieldForm()
  {
    $field = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'test'))
    ;

    $this->assertEquals(
      $this->expects('test-field-form'), 
      $field->form()
    );
  }

  public function testFieldFormSettingData()
  {
    $field = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'test'))
    ;

    $this->assertEquals(
      $this->expects('test-field-form-setting-data'), 
      $field->form()
    );
  }

  public function testRenderEmptyRegion()
  {
    $region = \Keystone\Region::makeWithName('body');

    $this->assertEquals(
      $this->expects('test-render-empty-region'),
      $region->form()
    );
  }

  public function testRenderRegionWithOneField()
  {
    $field1 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'test1'))
    ;
    $field2 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'test2'))
    ;

    $region = \Keystone\Region::makeWithName('body')
      ->addField($field1)
      ->addField($field2)
    ;

    $this->assertEquals(
      $this->expects('test-render-region-with-one-field'),
      $region->form()
    );
  }

  public function testRenderRegionWithOneFieldAndData()
  {
    $field = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'test'))
    ;

    $region = \Keystone\Region::makeWithName('body')
      ->addField($field)
    ;

    $this->assertEquals(
      $this->expects('test-render-region-with-one-field-and-data'), 
      $region->form()
    );
  }

  public function testRenderLayout()
  {
    Bundle::start('keystone');

    $field1 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'The Title'))
    ;
    $field2 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'Body Line 1'))
    ;
    $field3 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'Body Line 2'))
    ;

    $title = \Keystone\Region::makeWithName('title')
      ->addField($field1)
    ;

    $body = \Keystone\Region::makeWithName('body')
      ->addField($field2)
      ->addField($field3)
    ;

    $layout = \Keystone\Layout::makeWithName('test-render-layout.php')
      ->addRegion($title)
      ->addRegion($body)
    ;

    $this->assertEquals(
      $this->expects('test-render-layout'),
      $layout->form()
    );
  }

  public function testRenderTwigLayout()
  {
    Bundle::start('keystone');

    $field1 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'The Title'))
    ;
    $field2 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'Body Line 1'))
    ;
    $field3 = \Keystone\Field::makeWithType('plain')
      ->with('data', array('content' => 'Body Line 2'))
    ;

    $title = \Keystone\Region::makeWithName('title')
      ->addField($field1)
    ;

    $body = \Keystone\Region::makeWithName('body')
      ->addField($field2)
      ->addField($field3)
    ;

    $layout = \Keystone\Layout::makeWithName('test-render-twig-layout.twig')
      ->addRegion($title)
      ->addRegion($body)
    ;

    $this->assertEquals(
      $this->expects('test-render-twig-layout'),
      $layout->form()
    );
  }

}
