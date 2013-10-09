<?php

class Content extends Eloquent {

  public function type()
  {
    return $this->belongsTo('ContentType', 'content_type_id');
  }

  public function uris()
  {
    return $this->hasMany('ContentUri');
  }

  public function elementsForRegion(Region $region)
  {
    return ContentElement::where('content_id', '=', $this->getAttribute('id'))
      ->where('region_id', '=', $region->id)
      ->get();
    return $elements;
  }

  public function elementRevisionsForRegion(Region $region)
  {
    // ContentElementRevision::with(array('element' => function($query) use ($region) {
    //   return $query->where('content_id', '=', $this->id)->where('region_id', '=', $region->id);
    // }))->get();
    // header('Content-type: text/plain');
    // var_dump(DB::getQueryLog());
    // die;

    // return ContentElementRevision::with(array('element' => function($query) use ($region) {
    //   return $query->where('content_id', '=', $this->id)->where('region_id', '=', $region->id);
    // }))->get();
  }

  public function getRegion($slug)
  {
    return $region = Region::where('slug', '=', $slug)
      ->where('content_type_id', '=', $this->getAttribute('id'))
      ->first();
  }

  public function __isset($key)
  {
    return $this->getRegion($key);;
  }

  public function __get($key)
  {
    if ($region=$this->getRegion($key)) {
      return $this->elementsForRegion($region);
    }

    return parent::__get($key);
  }

}