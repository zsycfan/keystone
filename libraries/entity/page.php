<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{

  protected $_id;
  protected $_language;
  protected \Keystone\Layout $_layout;
  protected $_regions;
  protected \Keystone\Uri $_uri;
  protected $_title;
  protected $_excerpt;
  protected $_published;
  protected \Keystone\DateTime $_published_at;

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