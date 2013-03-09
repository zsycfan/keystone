@extends('keystone::layouts.base')

@section('content')
<form action="<?= URL::to('keystone/content/edit/'.$page['_id']) ?>" method="post">
  <p><input type="text" placeholder="Title..." name="node[title]" value="{{ $page['title'] }}" /></p>
  <p><input type="text" placeholder="Path..." name="node[path]" value="{{ $page['path'] }}" /></p>
  <p>
    <input type="hidden" name="node[body][0][type]" value="plain" />
    <textarea placeholder="Body..." name="node[body][0][content]">{{ @$page['body'][0]['content'] }}</textarea>
  </p>
  <p><input type="submit" /></p>
</form>
@stop