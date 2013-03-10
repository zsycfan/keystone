(function($){

  var methods = {

    // Set everything up
    init : function(options)
    {

      // Extend our default settings with any passed in options
      var settings = $.extend({
        'handle' : '',
        'placeholder': '<div class="placeholder" />',
        'draggingClass': 'dragging'
      }, options);

      // Mark the containers as draggable containers
      this.attr('data-draggable-container', true);

      // Set all the first children of the containers to be draggable
      var draggables = this.find('> *');

      // Setup our placeholder element and add it into the page as a hidden
      // element for later use
      var placeholder = $(settings.placeholder)
        .attr('data-draggable-placeholder', true)
        .css('position', 'absolute')
        .appendTo(document.body)
        .hide();
      
      // Watch for a mouse up anywhere on the page. If it's detected bail out
      // and drop any dragged elements into the page where they belong
      $(document).on('mouseup', function(event)
      {
        // We're not dragging anymore so hide the placeholder
        placeholder.hide();

        // Reset our cursor
        $(document.body).css('cursor', '');

        // Get the elements that were being dragged
        var dragged = $('[data-dragging]');

        // Loop through any elements that were dragging
        dragged.each(function() {

          // Determine if the dropped element should be above or below
          // the drop-element
          var action = $(this).data('drop-action');

          // Get the element we're inserting either before or after
          var element = $(this).data('drop-element');

          // Insert the element, i.e. $(existingRow).after(draggedRow)
          if (action && element) {
            element[action]($(this));

            // Run our sort finish handler if a move occurred
            if (settings.onSortFinish) {
              settings.onSortFinish.apply(dragged);
            }
          }
        });

        // Remove any references to an active drag event
        $('[data-dragging]').removeAttr('data-dragging').removeClass(settings.draggingClass);
      });

      // Watch for mouse movements
      $(document).on('mousemove', function(event)
      {

        // If nothing is actively being moved bail out as quick as possible
        if ($('[data-dragging]').length == 0) { return true; }

        // Loop through each draggable element and determine if we're nearby
        // var draggables = $('[data-draggable]:not([data-dragging])');
        var draggableElements = $('[data-draggable-container] > *').filter(':not([data-dragging])');
        for (i=0; len=draggableElements.length, i<len; i++) {

          // Localize our element
          var draggable = draggableElements.eq(i);

          // Figure out where we're located
          var location = draggable.location();

          // Figure out if we're in the top half of the element
          if (draggable.over(event.pageX, event.pageY) == 'topHalf' && draggable.prev().attr('data-dragging') == undefined) {
            $('[data-dragging]').data('drop-action', 'before').data('drop-element', draggable);
            placeholder.show().css({
              'width': draggable.outerWidth(),
              'top': draggable.offset().top,
              'left': draggable.offset().left,
            });
            return true;
          }

          // Figure out if we're in the bottom half of the element
          else if (draggable.over(event.pageX, event.pageY) == 'bottomHalf' && draggable.next().attr('data-dragging') == undefined) {
            $('[data-dragging]').data('drop-action', 'after').data('drop-element', draggable);
            placeholder.show().css({
              'width': draggable.outerWidth(),
              'top': draggable.offset().top + draggable.outerHeight(),
              'left': draggable.offset().left,
            });
            return true;
          }
        }

        // Loop through each empty draggable container and see if we're within
        // its bounds
        var draggableContainers = $('[data-draggable-container]:not(:has(*))');
        for (i=0; len=draggableContainers.length, i<len; i++) {

          // Localize our element
          var draggableContainer = draggableContainers.eq(i);

          // Figure out where we're located
          var location = draggableContainer.location();

          // Figure out if we're located within the bounds of the element
          if (draggableContainer.over(event.pageX, event.pageY, {minWidth:50, minHeight:50}) != false) {
            $('[data-dragging]').data('drop-action', 'append').data('drop-element', draggableContainer);
            placeholder.show().css({
              'width': draggableContainer.outerWidth(),
              'top': draggableContainer.offset().top,
              'left': draggableContainer.offset().left,
            });
            return true;
          }
        }

        // When everything else fails hide our placeholder and reset our
        // drop targets to nill
        $('[data-dragging]').data('drop-action', false).data('drop-element', false);
        placeholder.hide();
      });

      // Loop over the things to be converted to draggables
      $(document).on('mousedown', '[data-draggable-container] > * '+settings.handle, function()
      {
        // Add a dragging class
        $(this).parentsUntil('[data-draggable-container]').last().attr('data-dragging', true).addClass(settings.draggingClass);

        // Set our cursor
        $(document.body).css('cursor', 'move');
        
        return false;
      });

      return draggables;
    },
    update : function(content)
    {
      
    }
  };

  $.fn.sortable = function(method)
  {
    // Method calling logic
    if (methods[method]) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    }
    else if (typeof method === 'object' || ! method) {
      return methods.init.apply(this, arguments);
    }
    else {
      $.error('Method ' +  method + ' does not exist on jQuery.sortable');
    }    
  
  };

})( jQuery );