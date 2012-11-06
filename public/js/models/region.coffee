$(document).on 'region:update', '.region', (e)->
	$(this).attr 'data-count', $(this).find('.field:visible').size()
	if $(this).data('max') && $(this).find('.field').size() >= $(this).data('max')
		$(this).find('> .actions').hide()
		$(this).addClass 'filled'
	else
		$(this).find('> .actions').show()
		$(this).removeClass 'filled'