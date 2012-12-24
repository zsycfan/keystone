<?php

class Tags_Api
{
  public function get_index() {
    return Response::make(json_encode(array(
      array("id" => 0, "text" => Input::get('q')),
      array("id" => 1, "text" => "one"),
      array("id" => 2, "text" => "two"),
      array("id" => 3, "text" => "three"),
      array("id" => 4, "text" => "four")
    )), 200, array(
      'Content-type' => 'application/json'
    ));
  }
}