<?php

class Page extends Articulate
{

  public function revisions()
  {
    return $this->has_many('PageRevision');
  }

  public function revision_or_latest($revision=false)
  {
    if ($revision) {
      return $this->revisions()
        ->where('id', '=', $revision)
        ->first()
      ;
    }

    return $this->latest_revision();
  }

  public function latest_revision()
  {
    return $this->revisions()
      ->where('language', '=', 'en-us')
      ->order_by('id', 'desc')
      ->first()
    ;
  }

}