$(document).on 'submit', 'form:has([contenteditable])', ->

  # Give everything the proper nested name
  for el in $(this).find('.region *[name]')
    nameSegments = []
    for parent in $(el).parents('[data-name]')
      nameSegments.push $(parent).data('name') || $(parent).index()
    $(el).attr 'name', 'page[regions]['+nameSegments.reverse().join('][')+']['+$(el).attr('name')+']'

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