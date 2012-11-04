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
        <?= region(array('name' => 'body', 'as' => 'excerpt')) ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?= region(array('name' => 'postscript')) ?>
      </div>
    </div>
  </div>
</div>