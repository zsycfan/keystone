<div
  class="region"
  data-name="<?= $region->name ?>"
  data-allow='<?= htmlentities(json_encode(@$region->allow)) ?>'
  data-max="<?= $region->max ?>"
  data-min="<?= $region->min ?>"
  data-count="0"
  data-options="<?= htmlentities(json_encode($region->options)) ?>"
>
  <div class="fields">
    <?php if ($data): ?>
      <?php foreach ($data as $index => $field): ?>
        <div
          class="field-placeholder"
          data-type="<?= $field['type'] ?>"
          data-data="<?= htmlentities(json_encode($field)) ?>"
        ></div>
      <?php endforeach; ?>
    <?php elseif ($region->min > 0): ?>
      <div class="field-placeholder" data-type="plain"></div>
    <?php endif; ?>
    <?= @$fields ?>
  </div>
  <div class="actions">
    <a href="#" data-choose-field><i class="icon-plus"></i> <span>Add</span></a>
  </div>
</div>