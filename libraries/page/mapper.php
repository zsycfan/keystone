<?php

namespace Keystone\Page;
use DateTime;
use DateTimeZone;
use Keystone\Field;
use Keystone\Language;
use Keystone\Layout;
use Keystone\Object;
use Keystone\Page;
use Keystone\Region;
use Keystone\Uri;
use Laravel\Config;
use Laravel\Session;

class Mapper extends Object {

  public static function mapFromDatabase($row)
  {
    if (!$row) return false;

    $page = new Page;
    $page->id = $row->id;
    $page->language = Language::makeWithCountryCode($row->language);
    if($row->layout) $page->layout = Layout::makeWithName($row->layout);
    if($row->uri) $page->uri = Uri::makeFromString($row->uri);
    $page->createdAt = new DateTime($row->created_at, new DateTimeZone(Session::get('timezone', Config::get('application.timezone'))));
    $page->updatedAt = new DateTime($row->updated_at, new DateTimeZone(Session::get('timezone', Config::get('application.timezone'))));

    if ($regions = json_decode($row->regions, true)) {
      foreach ($regions as $region_name => $fields) {
        $region = Region::makeWithName($region_name);
        foreach ($fields as $field) {
          $region->addField(Field::makeWithType($field['type'])->setData($field['data']));
        }
        $page->layout->addRegion($region);
      }
    }
    
    return $page;
  }

  /**
   * Magic Method
   *
   * Takes any static calls to `mapAllFromX` and calls `mapFromX` on each item
   * in the array.
   * 
   * Returns a Collection of entities.
   * 
   * @param  string $method
   * @param  array  $args
   * @return mixed
   */
  public static function __callStatic($method, $args)
  {
    if (preg_match('/^mapAll(.*)$/', $method, $source)) {
      return Collection::makeWithResult(array_map(function($row) use ($source) {
        return call_user_func_array('\Keystone\Page\Mapper::map'.$source[1], array($row));
      }, $args[0]));
    }
  }

}
