<?php

namespace Keystone;

class Token
{

  public static function parse($stuff)
  {
    $tokens = array();

    if (is_array($stuff)) {
      foreach ($stuff as $item) {
        $tokens = array_merge($tokens, static::parse($item));
      }
      return $tokens;
    }

    if (is_string($stuff) && preg_match_all('/\[token:(.*?)\]/', $stuff, $matches)) {
      foreach ($matches[1] as $match) {
        $tokens[$match] = array('id' => 2, 'name' => 'two');
      }
    }

    return $tokens;
  }

}