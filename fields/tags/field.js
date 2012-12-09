$(document).on('click', '.ta-list a', function(e) {
  var input = $(this).closest('.ta-typeahead').data('typeahead-input');
  input.before('<input name="'+input.attr('data-typeahead-name')+'" value="'+$(this).data('data').id+'" />');
  return false;
});

$(function() {
	$('[data-typeahead]').data('typeahead-renderRow', function(data) {
		return '<li><a href="#" data-data="'+JSON.stringify(data).replace(/"/g,'&quot;')+'">'+data.tag+'</a></li>';
	});
});

$(document).on('keyup', '[data-typeahead]', function(event) {
	// Localize Variables
	var input = $(this);
	var popover = input.data('typeahead-popover') || $('<div class="ta-typeahead"><ul class="ta-list"></ul><i class="icon-undo"></i></div>').hide().appendTo(document.body);
	input.data('typeahead-popover', popover);
	popover.data('typeahead-input', input);

	// Localize api methods
	var renderRow = input.data('typeahead-renderRow');

	// Remove the popover if there is nothing to display
	if (!input.val() && !input.text()) {
		return popover.fadeOut();
	}

	// Apply styling and fade it in
	popover.css({
		'position':'absolute',
		'left':input.offset().left,
		'top':input.offset().top + input.height() + 20,
		'z-index': 9999,
		'background': '#fff',
		'box-shadow': '0 0 10px #000',
		'padding': 5,
		'border-radius': 4,
		'min-width': 200
	}).fadeIn();

	// Fetch the data for the popover
	$.get(input.data('typeahead-src'), function(data) {

		// Find our list of results
		var list = popover.find('.ta-list');
		var children = list.find('> *');
		var sorted = [];

		// Mark everything for removal
		children.attr('data-typeahead-remove', true);

		// Render each row
		for (var rowIndex=0; rowCount=data.length,rowIndex<rowCount; rowIndex++) {
			var row = $(renderRow(data[rowIndex]));

			// If the row exists, touch it so it's not removed in the upcoming
			// cleanup routine
			var matched = list.find('> *').filter(function(index) {
				return $(this).html() == row.html();
			}).removeAttr('data-typeahead-remove');

			// If the element is already in the DOM then we'll just note the
			// index so we can sort it later.
			if (matched.length != 0) {
				sorted.push(matched);
			}

			// If nothing matched add the new row into the dom and note it's
			// sort index
			else {
				list.append(row.hide());
				row.slideDown();
				sorted.push(row);
			}
		}

		// Remove rows that haven't been touched
		list.find('[data-typeahead-remove]').slideUp(function() {
			$(this).remove();
		});

		// Resort the list using the latest returned indexes
		for (var sortIndex=0; sortCount=sorted.length,sortIndex<sortCount; sortIndex++) {
			list.append(sorted[sortIndex]);
		}
	}, 'json');
});

$(document).on('focus', '[data-typeahead]', function(event) {
	var input = $(this);
	if (input.val()) {
		input.trigger('keyup');
	}
});

$(document).on('blur', '[data-typeahead]', function(event) {
	var popover = $(this).data('typeahead-popover');
	if (popover) {
		popover.fadeOut();
	}
});