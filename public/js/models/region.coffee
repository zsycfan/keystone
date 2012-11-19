$(document).on 'region:update', '.region', (e)->
	$(this).attr 'data-count', $(this).find('.field:visible').size()
	if $(this).data('max') && $(this).find('.field').size() >= $(this).data('max')
		$(this).find('> .add-field').hide()
		$(this).addClass 'filled'
	else
		$(this).find('> .add-field').show()
		$(this).removeClass 'filled'

$(document).on 'click', '[data-action="edit-layout"]', ->
  $(document.body).toggleClass 'editing'
  $(this).toggleClass 'active'
  $(this).toggleClass 'btn-warning'
  false