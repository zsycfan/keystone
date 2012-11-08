# Determine which regions can accept a drag on mouse down
$(document).on 'mousedown', '.fields .actions', (event)->
  field = $(this).closest '.field'
  $('.region').each ->
    allow = $(this).data('allow')
    if (allow && $.inArray(field.data('type'), allow) == -1)
      $(this).addClass 'restricted'
  $('.fields').sortable 'refresh'

$ ->

  # Enable sortable for fields
  window.sortable = $(".fields").sortable
    connectWith: '.region:not(.filled):not(.restricted) .fields'
    handle: '.actions'
    forcePlaceholderSize: true
    placeholder: 'ui-placeholder'
    cursorAt: {left: 30, top: 20}
    helper: (event, field)->
      field.find('.ui-helper').clone(true)
    start: (event, ui)->
      $(ui.item).addClass 'ui-drag-source'
      $(document.body).addClass 'ui-drag-active'
      $('.field:hidden').closest('.ui-sortable').addClass 'ui-sortable-original-parent'
      $('.ui-placeholder').closest('.region').addClass 'ui-sortable-droptarget'
    change: (event, ui)->
      $('.ui-sortable-droptarget').removeClass('ui-sortable-droptarget')
      $('.ui-placeholder').closest('.region').addClass 'ui-sortable-droptarget'
    stop: (event, ui)->
      $(ui.item).removeClass 'ui-drag-source'
      $('.ui-sortable-original-parent').removeClass 'ui-sortable-original-parent'
      $('.restricted').removeClass 'restricted'
      $(document.body).removeClass 'ui-drag-active'
      $('.ui-sortable-droptarget').removeClass 'ui-sortable-droptarget'
      for region in $('.region')
        $(region).trigger 'region:update'

  # Ingest existing fields
  $('.field-placeholder').each ->
    region = $(this).closest '.region'
    region.trigger 'region:addField', $(this).data()
    $(this).remove()

$(document).on 'region:update', '.region', (e)->
  if window.sortable
    $('.fields').sortable 'refresh'

# Add a field to the region
$(document).on 'region:addField', '.region', (e, field)->
  region = $(this)
  fields = region.find('.fields')
  
  icon = false
  if window.templates['field.'+field.type+'.icon']
    icon = window.templates['field.'+field.type+'.icon'] field.data || {}

  markup = window.templates['field']
    field: field
    icon: icon
    content: window.templates['field.'+field.type+'.field'] field.data || {}
  field = $(markup).appendTo fields
  field.trigger 'field:init'
  region.trigger 'region:update'