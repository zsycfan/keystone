<?php

class Keystone_Assets_Controller extends Base_Controller
{

  public function get_view($id)
  {
    $asset = Asset::find($id);
    return Response::make(file_get_contents($asset->path.$asset->name), 200, array(
      'Content-Type'              => $asset->mime,
      'Content-Transfer-Encoding' => $asset->type,
      'Content-Disposition'       => 'inline',
      'Expires'                   => 0,
      'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
      'Pragma'                    => 'public',
    ));
  }

  public function post_upload()
  {
    // list of valid extensions, ex. array("jpeg", "xml", "bmp")
    $allowedExtensions = array('jpg', 'png', 'gif');

    // max file size in bytes
    $sizeLimit = 100 * 1024 * 1024;

    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

    // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
    $result = $uploader->handleUpload('public/uploads/');

    if (@$result['success'] === true) {
      $result['asset'] = Asset::create(array(
        'path' => 'public/uploads/',
        'name' => $uploader->getUploadName(),
      ))->to_array();
    }

    // to pass data through iframe you will need to encode all html tags
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
  }

}