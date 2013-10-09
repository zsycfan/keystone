<?php

class Author extends Lascaux {

  public function posts()
  {
    return $this->hasMany('Post');
  }

  public function comments()
  {
    return $this->hasMany('Comment');
  }

  public function avatar()
  {
    return $this->hasMany('Avatar');
  }

}