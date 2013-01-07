<p>Title</p>
<?= $layout->getRegion('title')->with(array('max' => 1, 'min' => 1))->renderForm() ?>

<p>Body</p>
<?= $layout->getRegion('body')->renderForm() ?>