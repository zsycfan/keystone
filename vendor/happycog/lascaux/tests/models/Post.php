<?php

class Post extends Lascaux {

  public function author()
  {
    return $this->hasOne('Author');
  }

  public function comments()
  {
    return $this->hasMany('Comment');
  }

}