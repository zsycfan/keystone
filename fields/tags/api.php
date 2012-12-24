<?php

class Tags_Api
{
  public function get_index() {
    $result = array(
      array("id" => 1, "text" => "one"),
      array("id" => 2, "text" => "two"),
      array("id" => 3, "text" => "three"),
      array("id" => 4, "text" => "four")
    );

    if ($term = Input::get('q')) {
      array_unshift($result, array(
        "id" => $term, "text" => $term
      ));
    }

    return Response::make(json_encode($result), 200, array(
      'Content-type' => 'application/json'
    ));
  }
}