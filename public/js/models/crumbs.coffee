$ ->
  $(".crumbs").sticky()

$(document).on 'click', '[data-action="edit"]', ->
  $(document.body).toggleClass 'editing'
  $(this).toggleClass 'active'
  $(this).toggleClass 'btn-warning'
  false

$(document).on 'keyup', (event)->
  if (event.ctrlKey && event.keyCode == 69)
    $('[data-action="edit"]').trigger 'click'