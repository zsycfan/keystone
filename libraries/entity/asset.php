<?php

namespace Keystone\Entity;

class Asset extends \Keystone\Entity
{

  protected $src;
  protected $path;
  protected $name;
  protected $width;
  protected $height;
  protected $mime;
  protected $filesize;
  protected $type;

  public function set_src($src)
  {
    $this->attributes['src'] = $src;
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