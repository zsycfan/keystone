(function() {

  $(document).on('region:update', '.region', function(e) {
    $(this).attr('data-count', $(this).find('.field:visible').size());
    if ($(this).data('max') && $(this).find('.field').size() >= $(this).data('max')) {
      $(this).find('> .actions').hide();
      return $(this).addClass('filled');
    } else {
      $(this).find('> .actions').show();
      return $(this).removeClass('filled');
    }
  });

}).call(this);
