<?php

namespace Keystone;

class Page extends Articulate
{

  public function published()
  {
    return true;
  }

  public function revisions()
  {
    return $this->has_many('Keystone\PageRevision');
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