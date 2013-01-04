<?php

namespace Keystone\Page;
use DateTime;
use DateTimeZone;
use Keystone\Language;
use Keystone\Layout;
use Keystone\Object;
use Keystone\Page;
use Keystone\Uri;
use Laravel\Config;
use Laravel\Session;

class Mapper extends Object {

  public static function mapFromDatabase($row)
  {
    $page = new Page;
    $page->id = $row->id;
    $page->language = Language::makeWithCountryCode($row->language);
    $page->layout = Layout::makeNamed($row->layout);
    $page->uri = Uri::makeFromString($row->uri);
    $page->createdAt = new DateTime($row->created_at, new DateTimeZone(Session::get('timezone', Config::get('application.timezone'))));
    $page->updatedAt = new DateTime($row->updated_at, new DateTimeZone(Session::get('timezone', Config::get('application.timezone'))));
    return $page;
  }

  /**
   * Magic Method
   *
   * Takes any static calls to `mapAllFromX` and calls `mapFromX` on each item
   * in the array.
   * 
   * @param  string $method
   * @param  array  $args
   * @return mixed
   */
  public static function __callStatic($method, $args)
  {
    if (preg_match('/^mapAll(.*)$/', $method, $source)) {
      return Collection::makeWithResult(array_map(function($row) use ($source) {
        return call_user_func_array('\Keystone\Page\Mapper::map'.$source[1], $row);
      }, $args));
    }
  }

}
