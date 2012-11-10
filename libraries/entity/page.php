<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{

  protected $_id;           // int
  protected $_language;     // \Keystone\Language
  protected $_layout;       // \Keystone\Layout
  protected $_regions;      // \Keystone\Regions
  protected $_uri;          // \Keystone\Uri
  protected $_title;        // string
  protected $_excerpt;      // string
  protected $_published;    // bool
  protected $_published_at; // \Keystone\DateTime

  protected $accessible = array(
    'language',
    'layout',
    'regions',
    'uri',
    'title',
    'excerpt',
    'published',
    'published_at'
  );

  public function set_regions($regions=array())
  {
    $this->attributes['regions'] = $regions;
    $this->attributes['title'] = 'title';
    $this->attributes['excerpt'] = 'excerpt';
  }
}