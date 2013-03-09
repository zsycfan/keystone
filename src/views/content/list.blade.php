<p><a href="{{ URL::to('keystone/content/new?path='.Input::get('path')) }}">New</a></p>
<table>
@foreach ($pages as $page)
<tr>
  <td>
    <a href="{{ URL::to('keystone/content/list?path='.$page['path']) }}">{{ $page['title'] }}</a>
  </td>
  <td>
    <a href="{{ URL::to('keystone/content/edit/'.$page['_id']) }}">edit</a>
  </td>
</tr>
@endforeach
</table>