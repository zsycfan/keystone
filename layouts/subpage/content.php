<div class="row-fluid">
  <h1 class="span12">
    <?= region(array('name' => 'content.title', 'allow' => 'plain', 'max' => 1, 'min' => 1)) ?>
  </h1>
</div>

<div class="row-fluid">
  <div class="span3">
    <?= region(array('name' => 'content.sidebar', 'allow' => 'relationship')) ?>
  </div>
  <div class="span9">
    <div class="row-fluid">
      <div class="span12">
        <?= region(array('name' => 'content.body')) ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <?= region(array('name' => 'content.footer-left', 'allow' => array('asset', 'plain'))) ?>
      </div>
      <div class="span4">
        <?= region(array('name' => 'content.footer-center')) ?>
      </div>
      <div class="span4">
        <?= region(array('name' => 'content.footer-right')) ?>
      </div>
    </div>
  </div>
</div>