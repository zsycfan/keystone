(function() {

  $(function() {
    $(document).on('mousedown', '.fields .actions', function(event) {
      var field;
      field = $(this).closest('.field');
      $('.region').each(function() {
        var allow;
        allow = $(this).data('allow');
        if (allow && $.inArray(field.data('type'), allow) === -1) {
          return $(this).addClass('restricted');
        }
      });
      return $('.fields').sortable('refresh');
    });
    window.sortable = $(".fields").sortable({
      connectWith: '.region:not(.filled):not(.restricted) .fields',
      handle: '.actions',
      forcePlaceholderSize: true,
      placeholder: 'ui-placeholder',
      cursorAt: {
        left: 30,
        top: 20
      },
      helper: function(event, field) {
        return field.find('.ui-helper').clone(true);
      },
      start: function(event, ui) {
        $(ui.item).addClass('ui-drag-source');
        $(document.body).addClass('ui-drag-active');
        $('.field:hidden').closest('.ui-sortable').addClass('ui-sortable-original-parent');
        return $('.ui-placeholder').closest('.region').addClass('ui-sortable-droptarget');
      },
      change: function(event, ui) {
        $('.ui-sortable-droptarget').removeClass('ui-sortable-droptarget');
        return $('.ui-placeholder').closest('.region').addClass('ui-sortable-droptarget');
      },
      stop: function(event, ui) {
        var region, _i, _len, _ref, _results;
        $(ui.item).removeClass('ui-drag-source');
        $('.ui-sortable-original-parent').removeClass('ui-sortable-original-parent');
        $('.restricted').removeClass('restricted');
        $(document.body).removeClass('ui-drag-active');
        $('.ui-sortable-droptarget').removeClass('ui-sortable-droptarget');
        _ref = $('.region');
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          region = _ref[_i];
          _results.push($(region).trigger('region:update'));
        }
        return _results;
      }
    });
    return $('.field-placeholder').each(function() {
      var region;
      region = $(this).closest('.region');
      region.trigger('region:addField', $(this).data());
      return $(this).remove();
    });
  });

  $(document).on('region:update', '.region', function(e) {
    if (window.sortable) {
      return $('.fields').sortable('refresh');
    }
  });

  $(document).on('region:addField', '.region', function(e, field) {
    var fields, icon, markup, region;
    region = $(this);
    fields = region.find('.fields');
    icon = false;
    if (window.templates['field.' + field.type + '.icon']) {
      icon = window.templates['field.' + field.type + '.icon'](field.data || {});
    }
    markup = window.templates['field']({
      field: field,
      icon: icon,
      content: window.templates['field.' + field.type + '.field'](field.data || {})
    });
    field = $(markup).appendTo(fields);
    field.trigger('field:init');
    return region.trigger('region:update');
  });

}).call(this);
