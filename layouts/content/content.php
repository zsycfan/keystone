<div class="row-fluid">
  <h1 class="span12">
    <?= $layout->region('title')->with(array('allow' => array('plain'), 'max' => 1, 'min' => 1))->form() ?>
  </h1>
</div>

<div class="row-fluid">
  <div class="span12">
    <?= $layout->region('body')->form() ?>
  </div>
</div>