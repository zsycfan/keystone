$(document).on 'submit', 'form:has([contenteditable])', ->
  for el in $(this).find('[name]')
    if $(el).closest('.region').size()
      prefix = 'page[regions][' + $(el).closest('.region').data('name') + '][' + $(el).closest('.field').index() + ']'
      name = $(el).attr('name').replace(/\]$/, '').replace(/\[/, '][')
      $(el).attr('name', prefix + '[' + name + ']')
  for el in $(this).find('[contenteditable]')
    if $(el).text() == $(el).attr('placeholder')
      $(el).empty()
    name = $(el).attr 'name'
    if $('textarea[name="'+name+'"]').size() == 0
      $(el).after($('<textarea />', {name:name}).css({position: 'absolute', left: -9999, width: '100px'}))
    $('textarea[name="'+name+'"]').html($(el).html())
  true

$(document).on 'focus', '[contenteditable]', ->
  if $.trim($(this).text()) == $(this).attr('placeholder')
    $(this).empty()
    $(this).focus()

$(document).on 'blur', '[contenteditable]', ->
  if $(this).text() == ''
    $(this).html $(this).attr('placeholder')