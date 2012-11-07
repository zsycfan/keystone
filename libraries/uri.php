<?php

namespace Keystone;

class Uri
{

	public static function slugify($str)
  {
    $clean = preg_replace('/[^a-z0-9_-\s]/i', '', $str);
    $trimmed = trim($clean);
    $spaced = preg_replace('/\s+/', '-', $trimmed);
    return strtolower($spaced);
  }
	
}