<div class="row-fluid">
  <div class="span12">
    <p><strong>URI</strong></p>
    <?= region(array('name' => 'uri', 'allow' => 'plain', 'max' => 1, 'min' => 1, 'config.plain.placeholder' => 'uri...')) ?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12">
    <p><strong>Tags</strong></p>
    <?= region(array('name' => 'tags', 'allow' => 'tags', 'max' => 1, 'min' => 1)) ?>
  </div>
</div>