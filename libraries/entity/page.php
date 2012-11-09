<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{
  protected $accessible = array(
    'regions',
    'layout',
    'uri',
    'published_at',
    'language',
    'title',
    'excerpt',
    'published'
  );

  public function set_regions($regions=array())
  {
    $this->attributes['regions'] = $regions;
    $this->attributes['title'] = 'title';
    $this->attributes['excerpt'] = 'excerpt';
  }

  public function layout_form()
  {
    return new \Keystone\Layout($this->layout, $this->regions);
  }
}