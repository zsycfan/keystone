<?php

namespace Keystone;
use DateTime;

class Page extends Object
{
  private $id;
  private $language;
  private $layout;
  private $uri;
  private $createdAt;
  private $updatedAt;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }
  
  public function getLanguage()
  {
    return $this->language;
  }

  public function setLanguage(Language $language)
  {
    $this->language = $language;
  }

  public function getLayout()
  {
    return $this->layout;
  }

  public function setLayout(Layout $layout)
  {
    $this->layout = $layout;
  }
  
  public function getUri()
  {
    return $this->uri;
  }

  public function setUri(Uri $uri)
  {
    $this->uri = $uri;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function setCreatedAt(DateTime $createdAt)
  {
    $this->createdAt = $createdAt;
  }

  public function getTimeSinceCreated()
  {
    return date_create('now')->diff($this->createdAt);
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(DateTime $updatedAt)
  {
    $this->updatedAt = $updatedAt;
  }

  public function getTimeSinceUpdated()
  {
    return date_create('now')->diff($this->updatedAt);
  }

  public function getTitle()
  {
    return $this->layout->getRegion('title')->summary;
  }

  public function getExcerpt()
  {
    return $this->layout->getRegion('body')->summary;
  }
}
