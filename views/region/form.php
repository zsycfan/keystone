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
        <?= $field->with(array_get($config, $field->type, array()))->renderForm() ?>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php while ($count++ < $min): ?>
	  <?= Keystone\Field::makeWithType($type=current($allow))->with(array_get($config, $type))->renderForm() ?>
    <?php endwhile; ?>
  </div>
  <?php if ($max === false || $count < $max): ?>
    <div class="add-field">
      <a href="<?= URL::to_route('content_add_field', array($region->parentPage->id, $region->parentLayout->screen, $name)) ?>" data-choose-field><i class="icon-plus"></i> <span>Add</span></a>
    </div>
  <?php endif; ?>
</div>