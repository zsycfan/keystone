<?php

class ContentUri extends Eloquent {

  public function content()
  {
  	return $this->belongsTo('Content');
  }

  public function setUriAttribute($value)
  {
    $value = rtrim(ltrim($value, '/'), '/');
  	$this->attributes['uri'] = $value;

    $segments = array_merge(array_filter(preg_split('#/#', $value)));
    $segments = array_pad($segments, 21, null);
    foreach ($segments as $key => $value) {
      $this->attributes["segment{$key}"] = $value;
    }
  }

}