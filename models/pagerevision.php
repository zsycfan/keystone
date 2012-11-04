<?php

class PageRevision extends Articulate
{

  public static $table = 'page_revisions';

  public function get_published_at()
  {
    if (!$this->attributes['published_at']) {
      return null;
    }
    
    $date = new \WallabyDateTime($this->attributes['published_at'], new \DateTimeZone('UTC'));
    return $date->setTimeZone(new \DateTimeZone('America/New_York'));
  }

  public function set_published_at($date)
  {
    $date = new \DateTime($date, new \DateTimeZone('America/New_York'));
    $this->attributes['published_at'] = $date->setTimeZone(new \DateTimeZone('UTC'));
  }

  public function get_regions()
  {
    $regions = json_decode(@$this->attributes['regions'], true);

    if ($regions) {
      foreach ($regions as $region => &$fields) {
        foreach ($fields as $index => &$field) {
          $type = $field['type'];
          if (file_exists($path = path('fields').$type.'/field.php')) {
            require_once $path;
            $class = ucfirst($type).'_Field';
            if (class_exists($class)) {
              $obj = new $class;
              if (method_exists($obj, 'get')) {
                $field = $obj->get($field);
              }
            }
          }
        }
      }
    }

    return $regions;
  }

  public function set_regions($regions)
  {
    foreach ($regions as $region => &$fields) {
      foreach ($fields as $index => &$field) {
        $type = $field['type'];
        if (file_exists($path = path('fields').$type.'/field.php')) {
          require_once $path;
          $class = ucfirst($type).'_Field';
          if (class_exists($class)) {
            $obj = new $class;
            if (method_exists($obj, 'save')) {
              $field = $obj->save($field);
            }
          }
        }
      }
    }
    $this->attributes['regions'] = json_encode($regions);
  }

  public function event_saving()
  {
    if ($this->regions) {
      $title_key = false;
      if (isset($this->regions['title'])) $title_key = 'title';
      else if (isset($this->regions['name'])) $title_key = 'name';
      else if (isset($this->regions['heading'])) $title_key = 'heading';

      if ($title_key) {
        $this->attributes['title'] = WallabyJson::content($this->regions[$title_key]);
      }

      $excerpt_key = false;
      if (isset($this->regions['excerpt'])) $excerpt_key = 'excerpt';
      else if (isset($this->regions['body'])) $excerpt_key = 'body';
      else if (isset($this->regions['content'])) $excerpt_key = 'content';

      if ($excerpt_key) {
        $this->attributes['excerpt'] = strip_tags(WallabyJson::content($this->regions[$excerpt_key]));
      }

      if ($excerpt_key === 'excerpt') {
        $this->attributes['excerpt'] = Str::words($this->attributes['excerpt'], 20);
      }
    }
  }

  public function event_saved()
  {
    if ($this->published) {
      static
        ::where('language', '=', 'en-us')
        ->where('published', '=', 1)
        ->where($this->key(), '!=', $this->get_key())
        ->update(array('published' => 0))
      ;
    }
  }

}