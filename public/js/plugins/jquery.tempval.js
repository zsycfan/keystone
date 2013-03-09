(function($){

  var methods = {

    // Set everything up
    init : function(text)
    {
      return $(this).each(function() {
        if (!$(this).attr('data-default-value')) {
          $(this).attr('data-default-value', $(this).val());
        }
        $(this).val(text);
      });
    },
    reset : function()
    {
      return $(this).each(function() {
        if ($(this).attr('data-default-value')) {
          $(this).val($(this).attr('data-default-value'));
        }
        else {
          $(this).removeAttr('value');
        }
      });
    }
  };

  $.fn.tempVal = function(methodOrString)
  {
    method = methodOrString.substring(1);
    if (methods[method]) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    }
    else {
      return methods.init.apply(this, arguments);
    }
  
  };

})( jQuery );