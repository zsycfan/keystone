(function($){

  var timeout = false;

  var methods = {

    // Set everything up
    init : function(options)
    {
      $(this).find('input, textarea, select, div[contenteditable]').on('keyup change', function() {
        var field = $(this);
        var lastValue = field.attr('data-last-value');
        var currentValue = field.val() || field.text();

        // Check if the field has changed
        if (currentValue == lastValue) { return true; }
        field.attr('data-last-value', currentValue);

        // Are we already waiting for a save? If so, clear it out.
        if (timeout) {
          clearTimeout(timeout);
        }

        // Pause for a second before saving. This has the benefit of queuing up
        // saves instead of doing them every key up.
        timeout = setTimeout(function() {

          // Now kick off the save
          field.closest('form').trigger('submit');

        }, 1000);
      });
    },
    update : function(content)
    {
      
    }
  };

  $.fn.autoSubmit = function(method)
  {
    // Method calling logic
    if (methods[method]) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    }
    else if (typeof method === 'object' || ! method) {
      return methods.init.apply(this, arguments);
    }
    else {
      $.error('Method ' +  method + ' does not exist on jQuery.autoSubmit');
    }    
  
  };

})( jQuery );