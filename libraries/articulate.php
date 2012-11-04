<?php

class Articulate extends Eloquent
{

  public static function find_or_create($id)
  {
    if ($row = static::find($id)) {
      return $row;
    }
    else {
      return static::create($data);
    }
  }

  public function save()
  {
    if (!parent::save()) {
      throw new Exception('Unable to save.');
    }
    return $this;
  }

  public function touch()
  {
    $this->timestamp();
    return $this->save();
  }

  public function duplicate()
  {
    $new = new static();
    $new->fill_raw($this->attributes);
    $new->purge($this->key());
    return $new;
  }

}