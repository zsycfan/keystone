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
        <?= region(array('name' => 'content.body', 'as' => 'excerpt')) ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?= region(array('name' => 'content.postscript')) ?>
      </div>
    </div>
  </div>
</div>