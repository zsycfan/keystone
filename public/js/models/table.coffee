$ ->
  window.sortable = $("tbody").sortable
    handle: '.move'
    placeholder: 'keystone-ui-placeholder'
    cursor: '-webkit-grabbing'
    cursorAt: {left: 15, top: 15}
    helper: (event, tr)->
      el = $('<div class="keystone-ui-helper"><i class="icon-file" /></div>').show()
      $(document.body).append(el)
      el
    start: (event, ui)->
      ui.item.addClass('keystone-ui-source').show()
      ui.placeholder.hide()
    change: (event, ui)->
      ui.placeholder.show().css('width', ui.placeholder.parent().width())
      if (ui.placeholder.prev().hasClass('keystone-ui-source'))
        ui.placeholder.addClass('hidden') 
      else if (ui.placeholder.next().hasClass('keystone-ui-source'))
        ui.placeholder.addClass('hidden') 
      else
        ui.placeholder.removeClass('hidden') 
    stop: (event, ui)->
      $(ui.item).removeClass 'keystone-ui-source'