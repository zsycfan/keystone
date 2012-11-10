<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{

  protected \Keystone\Number $_id;
  protected \Keystone\Language $_language;
  protected \Keystone\Layout $_layout;
  protected \Keystone\Regions $_regions;
  protected \Keystone\Uri $_uri;
  protected \Keystone\String $_title;
  protected \Keystone\String $_excerpt;
  protected \Keystone\String $_published;
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