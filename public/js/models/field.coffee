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
    cursor: 'grabbing'
    cursorAt: {left: 30, top: 20}
    helper: (event, field)->
      field.find('.ui-helper').clone(true).show()
    start: (event, ui)->
      $(ui.item).addClass 'ui-drag-source'
      $(document.body).addClass 'ui-drag-active'
      $('.field:hidden').closest('.ui-sortable').addClass 'ui-sortable-original-parent'
      $('.ui-placeholder').addClass('hidden').closest('.region').addClass 'ui-sortable-droptarget'
    change: (event, ui)->
      $('.ui-sortable-droptarget').removeClass('ui-sortable-droptarget')
      $('.ui-placeholder').closest('.region').addClass 'ui-sortable-droptarget'
      if ($('.ui-placeholder').prev().hasClass('ui-drag-source'))
        $('.ui-placeholder').addClass('hidden') 
      else if ($('.ui-placeholder').next().hasClass('ui-drag-source'))
        $('.ui-placeholder').addClass('hidden') 
      else
        $('.ui-placeholder').removeClass('hidden') 
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
    region.trigger 'region:addField', [$(this).data(), $(this)]

$(document).on 'region:update', '.region', (e)->
  if window.sortable
    $('.fields').sortable 'refresh'

# Add a field to the region
$(document).on 'region:addField', '.region, .field', (e, field, placeholder)->
  region = $(this)
  fields = region.find('.fields:first')

  if !field.data
    field.data = {}

  config = []
  if region.data('config')
    config = region.data('config')[field.type]
  field.data.config = config

  icon = false
  if window.templates['field.'+field.type+'.icon']
    icon = window.templates['field.'+field.type+'.icon'] field.data || {}

  markup = window.templates['field']
    field: field
    icon: icon
    topLevel: region.hasClass 'region'
    content: window.templates['field.'+field.type+'.field'] field.data || {}

  el = $(markup)

  window.popoverCount = 0;
  popover = el.find('.more').click(->(false)).popover
    template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><div /></div></div></div>'
    title: field.type
    html: true
    content: '<p>This field has no additional options.</p> <div class="tooltip-actions"><a class="btn btn-danger" href="#" data-action="remove-field"><i class="icon-trash"></i></a></div>'
    placement: (tip, caller)->
      $(tip).attr('data-popover', 'popover'+window.popoverCount);
      $(caller).closest('.field').attr('data-popover', 'popover'+window.popoverCount);
      window.popoverCount++
      "left"

  if (placeholder)
    placeholder.replaceWith el
  else
    fields.append el

  el.trigger 'field:init'
  region.trigger 'region:update'

  el.find('.field-placeholder').each ->
    field = $(this).closest('.field')
    field.trigger 'region:addField', [$(this).data(), $(this)]

  false

$(document).on 'click', '[data-action="remove-field"]', ->
  popover = $(this).closest('.popover')
  id = popover.data('popover')
  $('.field[data-popover="'+id+'"]').remove()
  popover.remove()
  false

htmlEntities = (str)->
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

Handlebars.registerHelper 'field', (type, name, options)->
  '<div class="field-placeholder" data-type="'+type+'" data-name="'+name+'" data-data="'+htmlEntities(JSON.stringify(this[name]))+'"></div>'