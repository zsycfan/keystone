(function($){

  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
               .toString(16)
               .substring(1);
  };

  function guid() {
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
           s4() + '-' + s4() + s4() + s4();
  }

  $.fn.contenteditable = function(options)
  {
    $(this).find('div[contenteditable]').each(function() {
      var value = $(this).html();
      var name = $(this).attr('name');

      var id = $(this).attr('data-textarea-id');
      if (!id) {
        id = guid();
        $(this).attr('data-textarea-id', id);
      }

      var textarea = $('input[data-textarea-id="'+id+'"]');
      if (!textarea.length) {
        textarea = $('<input type="hidden" />')
          .attr('data-textarea-id', id)
          .insertAfter(this)
        ;
      }

      textarea.attr('name', name).val(value);
    });
    return $(this);
  };

})( jQuery );