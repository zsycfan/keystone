$(document).on 'submit', 'form:has([contenteditable])', ->

  # Give everything the proper nested name
  for layout in $(this).find('.layout')
    for el in $(layout).find('.region *[name]')
      nameSegments = []
      for parent in $(el).parents('[data-name]')
        if $(parent).hasClass('layout')
          break
        nameSegments.push $(parent).data('name') || $(parent).index()
      name = $(el).attr('name').replace(/\[\]$/, '')
      arr = if $(el).attr('name').match(/\[\]$/) then '[]' else ''
      $(el).attr 'name', 'page[regions]['+nameSegments.reverse().join('][')+']['+name+']'+arr

  # Turn content editables into actual textareas
  for el in $(this).find('[contenteditable]')
    if $(el).text() == $(el).attr('placeholder')
      $(el).empty()
    name = $(el).attr 'name'
    if $('textarea[name="'+name+'"]').size() == 0
      $(el).after($('<textarea />', {name:name}).css({position: 'absolute', left:-9999, width:0}))
    $('textarea[name="'+name+'"]').html($(el).html())

  # Form submit!
  true

$(document).on 'focus', '[contenteditable]', ->
  if $.trim($(this).text()) == $(this).attr('placeholder')
    $(this).empty()
    $(this).focus()

$(document).on 'blur', '[contenteditable]', ->
  if $(this).text() == ''
    $(this).html $(this).attr('placeholder')