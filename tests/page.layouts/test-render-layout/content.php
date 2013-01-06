<p>Title</p>
<?= $layout->region('title')->with(array('max' => 1, 'min' => 1))->form() ?>

<p>Body</p>
<?= $layout->region('body')->form() ?>