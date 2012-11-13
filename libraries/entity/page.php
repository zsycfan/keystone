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

  /**
   * Fill and Translate raw database/post data into the appropriate entities
   * and PHP classes.
   * 
   * @param  array $attributes
   * @param  boolean $raw
   * @return \Keystone\Entity
   */
  public function fill_and_translate($attributes, $raw=false)
  {
    // Make sure we're always working with an array since the DB pass an object
    // but form post data will be an array
    $attributes = (array)$attributes;

    // Decode our regions
    if (isset($attributes['regions'])) {
      $this->regions = new \Keystone\Regions();
      $regions = $attributes['regions'];
      if (is_string($regions)) {
        $regions = json_decode($attributes['regions'], true);
      }
      if (is_array($regions)) {
        foreach ($regions as $name => &$region) {
          $this->regions->add(new \Keystone\Region(array('name' => $name, 'fields' => $region)));
        }
      }
    }

    // Make our layout an object
    if (isset($attributes['layout']) && is_string($attributes['layout'])) {
      $this->layout = new \Keystone\Layout($attributes['layout'], $this->regions);
    }

    // Return the page entity
    $this->fill(array_diff_key($attributes, array('regions'=>'', 'layout'=>'')), $raw);
    return $this;
  }

  // public function set_regions(\Keystone\Regions $regions)
  // {
  //   $this->attributes['regions'] = $regions;

  //   if ($title = $regions->title_region()) {
  //     $this->attributes['title'] = $title->summary();
  //   }

  //   if ($excerpt = $regions->excerpt_region()) {
  //     $this->attributes['excerpt'] = $excerpt->summary();
  //   }
  // }
}