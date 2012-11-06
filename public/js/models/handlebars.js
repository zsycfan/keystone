(function() {

  Handlebars.registerHelper('inArray', function(needle, haystack, block) {
    var value, _i, _len, _ref;
    if (!this.allow) {
      return block.fn(this);
    }
    _ref = this.allow;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      value = _ref[_i];
      if (value === needle) {
        return block.fn(this);
      }
    }
    return '';
  });

  Handlebars.registerHelper('fieldIcon', function(field, block) {
    var context, partial, templateName;
    templateName = 'field.' + field + '.icon';
    partial = Handlebars.partials[templateName];
    if (typeof partial === "string") {
      partial = Handlebars.compile(partial);
      Handlebars.partials[templateName] = partial;
    }
    context = $.extend({}, this, block.hash);
    return new Handlebars.SafeString(partial(context));
  });

  $(function() {
    window.templates = window.partials = [];
    $('.handlebars-template').each(function() {
      return window.templates[$(this).data('name')] = Handlebars.compile($(this).html());
    });
    return $('.handlebars-partial').each(function() {
      return window.partials[$(this).data('name')] = Handlebars.registerPartial($(this).data('name'), $(this).html());
    });
  });

}).call(this);
