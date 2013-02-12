<div class="row-fluid">
  <div class="span12">
    <p><strong>URI</strong></p>
    <?= $layout->getRegion('uri')->with(array('allow' => array('plain'), 'max' => 1, 'min' => 1, 'config.plain.placeholder' => 'uri...'))->renderForm() ?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12">
    <p><strong>Tags</strong></p>
    <?= $layout->getRegion('tags')->with(array('allow' => array('tags'), 'max' => 1, 'min' => 1))->renderForm() ?>
  </div>
</div>