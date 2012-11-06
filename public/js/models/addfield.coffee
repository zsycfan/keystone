$(document).on 'click', '[data-choose-field]', (e)->
	region = $(this).closest '.region'
	markup = window.templates['field_chooser'] region.data()
	modal = $(markup)
	modal.appendTo '.modals'
	modal.data 'region', region
	modal.modal 'show'
	modal.on 'hidden', ->
		$(this).remove()
	false

$(document).on 'click', '[data-add-field]', (e)->
	modal = $(this).closest('.modal')
	region = modal.data('region')
	region.trigger 'region:addField', $(this).data()
	modal.modal 'hide'
	false