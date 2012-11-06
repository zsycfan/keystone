# Give Handlebars an inArray function/block
Handlebars.registerHelper 'inArray', (needle, haystack, block)->
  if !this.allow
    return block.fn this
  for value in this.allow when value == needle
    return block.fn this
  ''

# Give Handlebars way to access dynamic partials
Handlebars.registerHelper 'fieldIcon', (field, block)->
  templateName = 'field.'+field+'.icon'
  partial = Handlebars.partials[templateName]
  if (typeof partial is "string")
    partial = Handlebars.compile(partial)
    Handlebars.partials[templateName] = partial
  context = $.extend({}, this, block.hash)
  new Handlebars.SafeString partial(context)

$ ->
  # Store the handlebar templates in the window object so they're accessiable
  # outside this function.
  window.templates = window.partials = []

  # Loop through any handlebar templates in the source and compile them into 
  # the window object.
  $('.handlebars-template').each ->
    window.templates[$(this).data('name')] = Handlebars.compile $(this).html()

  # Loop through any handlebar partials in the source and compile them into 
  # the window object.
  $('.handlebars-partial').each ->
    window.partials[$(this).data('name')] = Handlebars.registerPartial $(this).data('name'), $(this).html()