<div class="row-fluid">
  <h1 class="span12">
    <?= region(array('name' => 'title', 'allow' => 'plain', 'max' => 1, 'min' => 1)) ?>
  </h1>
</div>

<div class="row-fluid">
  <div class="span3">
    <?= region(array('name' => 'sidebar', 'allow' => 'relationship')) ?>
  </div>
  <div class="span9">
    <div class="row-fluid">
      <div class="span12">
        <?= region(array('name' => 'body')) ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <?= region(array('name' => 'footer-left', 'allow' => array('asset'))) ?>
      </div>
      <div class="span4">
        <?= region(array('name' => 'footer-center')) ?>
      </div>
      <div class="span4">
        <?= region(array('name' => 'footer-right')) ?>
      </div>
    </div>
  </div>
</div>