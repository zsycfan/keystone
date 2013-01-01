<?php

namespace Keystone;

class Page extends Object
{
  private $id;
  private $language;
  private $layout;
  private $uri;

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setLanguage(Language $language)
  {
    $this->language = $language;
  }

  public function setLayout(Layout $layout)
  {
    $this->layout = $layout;
  }

  public function setUri(Uri $uri)
  {
    $this->uri = $uri;
  }
}
