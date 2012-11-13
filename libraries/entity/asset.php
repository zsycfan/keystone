<?php

namespace Keystone\Entity;

class Asset extends \Keystone\Entity
{

  // protected $path;     // string
  // protected $name;     // string
  // protected $type;     // string
  // protected $mime;     // string
  // protected $width;    // number
  // protected $height;   // number
  // protected $filesize; // number
  // protected $caption;  // string
  // protected $credit;   // string

  public function __construct($src=false)
  {
    if ($src) {
      $this->attributes['path'] = dirname($src).'/';
      $this->attributes['name'] = basename($src);
      if ($image = @getimagesize($src)) {
        $this->attributes['width'] = $image[0];
        $this->attributes['height'] = $image[1];
      }
      $this->attributes['filesize'] = \File::size($src);
      $this->attributes['type'] = \File::type($src);
      $this->attributes['mime'] = \File::mime(\File::extension($src));
    }
  }

}