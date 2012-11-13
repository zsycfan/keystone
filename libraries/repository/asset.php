<?php

namespace Keystone\Repository;
use \DB;

class Asset
{

  public static function save(\Keystone\Entity\Asset $asset)
  {
    if ($asset->id) {
      DB::table('assets')
        ->where('id', '=', $asset->id)
        ->update(array(
          'path' => $asset->path,
          'name' => $asset->name,
          'type' => $asset->type,
          'mime' => $asset->mime,
          'width' => $asset->width,
          'height' => $asset->height,
          'filesize' => $asset->filesize,
          'caption' => null,
          'credit' => null,
          'updated_at' => date('Y-m-d G:i:s'),
        ))
      ;
    }
    else {
      $asset->id = DB::table('assets')->insert_get_id(array(
        'path' => $asset->path,
        'name' => $asset->name,
        'type' => $asset->type,
        'mime' => $asset->mime,
        'width' => $asset->width,
        'height' => $asset->height,
        'filesize' => $asset->filesize,
        'caption' => null,
        'credit' => null,
        'updated_at' => date('Y-m-d G:i:s'),
        'created_at' => date('Y-m-d G:i:s'),
      ));
    }
  }

}