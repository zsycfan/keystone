(function() {

  $(document).on('click', '[data-choose-field]', function(e) {
    var markup, modal, region;
    region = $(this).closest('.region');
    markup = window.templates['field_chooser'](region.data());
    modal = $(markup);
    modal.appendTo('.modals');
    modal.data('region', region);
    modal.modal('show');
    modal.on('hidden', function() {
      return $(this).remove();
    });
    return false;
  });

  $(document).on('click', '[data-add-field]', function(e) {
    var modal, region;
    modal = $(this).closest('.modal');
    region = modal.data('region');
    region.trigger('region:addField', $(this).data());
    modal.modal('hide');
    return false;
  });

}).call(this);
