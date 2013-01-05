<?php

namespace Keystone;

class Language extends Object
{

  private $countryCode = 'en-us';

  public static function makeWithCountryCode($code)
  {
    $obj = new static;
    $obj->countryCode = $code;
    return $obj;
  }

}