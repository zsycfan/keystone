$ ->
  $(".crumbs").sticky()

$(document).on 'click', '[data-action="edit"]', ->
  $(document.body).toggleClass 'editing'
  $(this).toggleClass 'active'
  $(this).toggleClass 'btn-warning'
  false