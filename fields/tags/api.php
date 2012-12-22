<?php

class Tags_Api
{
  public function get($keys) {
    return array(
      array('id' => 1, 'name' => 'test'),
      array('id' => 2, 'name' => 'two'),
      array('id' => 3, 'name' => 'another'),
      array('id' => 4, 'name' => 'blah'),
      array('id' => 5, 'name' => date('r')),
    );
  }
}