<?php

class Comment extends Lascaux {

  public function post()
  {
    return $this->belongsTo('Post');
  }

  public function author()
  {
  	return $this->belongsTo('Author');
  }

}