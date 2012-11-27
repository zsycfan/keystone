<?php

namespace Keystone\Entity;

class Page extends \Keystone\Entity
{

  // protected $_id;            // int
  // protected $_published_id   // int
  // protected $_revision_id;   // int
  // protected $_language;      // \Keystone\Language
  // protected $_layout;        // \Keystone\Layout
  // protected $_regions;       // \Keystone\Regions
  // protected $_uri;           // \Keystone\Uri
  // protected $_title;         // string
  // protected $_excerpt;       // string
  // protected $_published;     // bool
  // protected $_published_at;  // \Keystone\DateTime
  // protected $_created_at;    // \DateTime
  // protected $_created_since; // \DateInterval
  // protected $_updated_at;    // \DateTime
  // protected $_updated_since; // \DateInterval

  public function __construct($data=array())
  {
    parent::__construct($data);
    if (!@$this->attributes['language']) {
      $this->attributes['language'] = 'en-us';
    }
    if (!@$this->attributes['regions']) {
      $this->attributes['regions'] = new \Keystone\Regions();
    }
  }

  public function get_title()
  {
    return $this->regions->title_region()->summary();
  }

  public function get_excerpt()
  {
    return $this->regions->excerpt_region()->summary();
  }

  public function set_uri_by_parent($parent)
  {
    $slug = strtolower(preg_replace(array('/[^a-z0-9_-]/i', '/\s+/'), array('', '-'), trim($this->get_title())));
    $uri = ltrim($parent.'/'.$slug, '/');
    $this->set_uri($uri);
  }

  public function set_uri($uri=false)
  {
    $index = '';

    try {
      if ($uri == false) {
        throw new \Exception('empty uri');
      }

      while (($page=\Keystone\Repository\Page::find_by_uri($uri.$index)) && $page->id != $this->id) {
        $uri = preg_replace('/\d+\s*$/', '', $uri);
        $index++;
      }
    }
    catch (\Exception $e) {
      $this->attributes['uri'] = $uri.$index;
    }
  }
}