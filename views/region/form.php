<div
  class="region"
  data-name="<?= $name ?>"
  data-allow="<?= htmlentities(json_encode($allow)) ?>"
  data-max="<?= $max ?>"
  data-min="<?= $min ?>"
  data-count="<?= $count ?>"
  data-config="<?= htmlentities(json_encode($config)) ?>"
>
  <div class="fields">
    <?php if ($fields): ?>
      <?php foreach ($fields as $index => $field): ?>
        <?= $field->form() ?>
      <?php endforeach; ?>
    <?php elseif ($min > 0): ?>
      <div class="field-placeholder" data-type="<?= current($region->allow) ?:'plain' ?>"></div>
    <?php endif; ?>
  </div>
  <div class="add-field">
    <a href="#" data-choose-field><i class="icon-plus"></i> <span>Add</span></a>
  </div>
</div>