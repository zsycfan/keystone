<?php

namespace Keystone\Page;
use DateTime;
use Keystone\Language;
use Keystone\Layout;
use Keystone\Object;
use Keystone\Page;
use Keystone\Uri;

class Mapper extends Object {

  public static function mapAll(array $result)
  {
    return Collection::makeWithResult(array_map(function($row) {
      return Mapper::map($row);
    }, $result));
  }

  public static function map($row)
  {
    $page = new Page;
    $page->id = $row->id;
    $page->language = Language::makeWithCountryCode($row->language);
    $page->layout = Layout::makeNamed($row->layout);
    $page->uri = Uri::makeFromString($row->uri);
    $page->createdAt = new DateTime($row->created_at);
    $page->updatedAt = new DateTime($row->updated_at);
    return $page;
  }

}
