<?php

class TagsField extends \Keystone\Field
{
  public function setDataFromPost($data)
  {
    $data['tags'] = preg_split('/,/', $data['tags']);
    return parent::setData($data);
  }
}