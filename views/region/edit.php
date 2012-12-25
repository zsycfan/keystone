<div
  class="region"
  data-name="<?= $region->name ?>"
  data-as="<?= $region->as ?>"
  data-allow='<?= htmlentities(json_encode($region->allow)) ?>'
  data-max="<?= $region->max ?>"
  data-min="<?= $region->min ?>"
  data-count="0"
  data-config="<?= htmlentities(json_encode($region->config)) ?>"
>
  <input type="hidden" name="name" value="<?= $region->name ?>" />
  <input type="hidden" name="as" value="<?= $region->as ?>" />
  <input type="hidden" name="allow" value="<?= htmlentities(json_encode($region->allow)) ?>" />
  <input type="hidden" name="max" value="<?= $region->max ?>" />
  <input type="hidden" name="min" value="<?= $region->min ?>" />
  <input type="hidden" name="count" value="0" />
  <input type="hidden" name="config" value="<?= htmlentities(json_encode($region->config)) ?>" />
  
  <div class="fields" data-name="fields">
    <?php if ($region->fields): ?>
      <?php foreach ($region->fields as $index => $field): ?>
        <div
          class="field-placeholder"
          data-type="<?= $field['type'] ?>"
          data-data="<?= htmlentities(json_encode($field)) ?>"
        ></div>
      <?php endforeach; ?>
    <?php elseif ($region->min > 0): ?>
      <div class="field-placeholder" data-type="<?= current($region->allow) ?:'plain' ?>"></div>
    <?php endif; ?>
  </div>
  <div class="add-field">
    <a href="#" data-choose-field><i class="icon-plus"></i> <span>Add</span></a>
  </div>
</div>