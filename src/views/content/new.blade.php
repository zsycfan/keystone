<form action="<?= URL::to('keystone/content/new') ?>" method="post">
  <p><input type="text" placeholder="Title..." name="node[title]" /></p>
  <p>
    <input type="hidden" name="pathPrefix" value="{{ Input::get('path')?Input::get('path').'/':'' }}" />
    {{ Input::get('path') }}/<input type="text" placeholder="Path..." name="node[path]" />
  </p>
  <p><input type="submit" /></p>
</form>