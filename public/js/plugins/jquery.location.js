(function($){

  $.fn.location = function(options)
  {
    var settings = $.extend({
      'minWidth': 0,
      'minHeight': 0
    }, options);

    var width = $(this).outerWidth();
    var height = $(this).outerHeight();
    var top = $(this).offset().top;
    var bottom = top + height;
    var left = $(this).offset().left;
    var right = left + width;

    if (height < settings.minHeight) {
      height = settings.minHeight;
      bottom = top + settings.minHeight;
    }

    if (width == settings.minWidth) {
      width = settings.minWidth;
      right = left + settings.minWidth;
    }

    return {
      'width': width,
      'height': height,
      'top': top,
      'bottom': bottom,
      'left': left,
      'right': right
    }
  };

})( jQuery );