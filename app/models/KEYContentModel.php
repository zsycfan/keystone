<?php

class KEYContentModel {

  public static function getByUri($uri)
  {
    $content = new KEYContent;

    $uriRow = DB::table('content_uris')->where('uri', '=', $uri)->first();
    $contentRow = DB::table('contents')->find($uriRow->content_id);
    $typeRow = DB::table('content_types')->find($contentRow->content_type_id);
    $elementRows = DB::table('content_elements')
      ->select(array('regions.name AS regionName', 'regions.slug AS regionSlug'))
      ->join('regions', 'regions.id', '=', 'content_elements.region_id')
      ->join('elements', 'elements.id', '=', 'content_elements.element_id')
      ->where('content_id', '=', $contentRow->id)
      ->get();

    $type = new KEYContentType;
    $type->name = $typeRow->name;
    $type->slug = $typeRow->slug;
    $type->rows = $typeRow->rows;
    $content->type = $type;

    foreach ($elementRows as $row) {
      $region = new KEYRegion;
      $region->name = $row->regionName;
      $region->slug = $row->regionSlug;
      $element = new KEYContentElement;
      $element->region = $region;
      $content->addElement($element);
    }

    return $content;
  }

}