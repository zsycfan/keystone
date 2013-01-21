<div class="row-fluid">
  <h1 class="span12">
    <?= $layout->getRegion('title')->with(array('allow' => array('plain'), 'max' => 1, 'min' => 1))->renderForm() ?>
  </h1>
</div>

<div class="row-fluid">
  <div class="span3">
    <?= $layout->getRegion('sidebar')->with(array('allow' => array('relationship')))->renderForm() ?>
  </div>
  <div class="span9">
    <div class="row-fluid">
      <div class="span12">
        <?= $layout->getRegion('body')->renderForm() ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?= $layout->getRegion('postscript')->renderForm() ?>
      </div>
    </div>
  </div>
</div>