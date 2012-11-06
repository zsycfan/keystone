(function() {

  $(document).on('submit', 'form:has([contenteditable])', function() {
    var el, name, prefix, _i, _j, _len, _len1, _ref, _ref1;
    _ref = $(this).find('[name]');
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      el = _ref[_i];
      if ($(el).closest('.region').size()) {
        prefix = 'regions[' + $(el).closest('.region').data('name') + '][' + $(el).closest('.field').index() + ']';
        name = $(el).attr('name').replace(/\]$/, '').replace(/\[/, '][');
        $(el).attr('name', prefix + '[' + name + ']');
      }
    }
    _ref1 = $(this).find('[contenteditable]');
    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
      el = _ref1[_j];
      if ($(el).text() === $(el).attr('placeholder')) {
        $(el).empty();
      }
      name = $(el).attr('name');
      if ($('textarea[name="' + name + '"]').size() === 0) {
        $(el).after($('<textarea />', {
          name: name
        }).css({
          position: 'absolute',
          left: -9999,
          width: '100px'
        }));
      }
      $('textarea[name="' + name + '"]').html($(el).html());
    }
    return true;
  });

  $(document).on('focus', '[contenteditable]', function() {
    if ($(this).text() === $(this).attr('placeholder')) {
      return $(this).empty();
    }
  });

  $(document).on('blur', '[contenteditable]', function() {
    if ($(this).text() === '') {
      return $(this).html($(this).attr('placeholder'));
    }
  });

}).call(this);
