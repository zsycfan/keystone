<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{

  // protected $_id;           // int
  // protected $_language;     // \Keystone\Language
  // protected $_layout;       // \Keystone\Layout
  // protected $_regions;      // \Keystone\Regions
  // protected $_uri;          // \Keystone\Uri
  // protected $_title;        // string
  // protected $_excerpt;      // string
  // protected $_published;    // bool
  // protected $_published_at; // \Keystone\DateTime
  // protected $_created_at;   // \DateTime
  // protected $_updated_at;   // \DateTime

  public function get_title()
  {
    return $this->regions->title_region()->summary();
  }

  public function get_excerpt()
  {
    return $this->regions->excerpt_region()->summary();
  }
}