(function($){

  var methods = {

    init : function(options)
    {
      $(this).find('input, textarea, select, button, div[contenteditable]').each(function() {
        var field = $(this);

        if (!field.attr('data-matryoshka')) {
          field.attr('data-matryoshka', field.attr('name'));
        }

        if (!field.attr('data-matryoshka')) return true;

        var parents = field.parents('[data-matryoshka]').andSelf();
        var parentNames = [];

        parents.each(function(count) {
          var name = $(this).attr('data-matryoshka');
          name = name.replace(':index', $(this).index());
          if (count > 0 && name[name.length-1] != ']') {
            name = '['+name+']';
          }
          parentNames.push(name);
        });
        
        field.attr('name', parentNames.join(''));
      });

      return $(this);
    }
  };

  $.fn.matryoshka = function(method)
  {
    // Method calling logic
    if (methods[method]) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    }
    else if (typeof method === 'object' || ! method) {
      return methods.init.apply(this, arguments);
    }
    else {
      $.error('Method ' +  method + ' does not exist on jQuery.matryoshka');
    }    
  
  };

})( jQuery );