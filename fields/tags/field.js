$(document).on('click', function(event) {
	$('.tags-field-selected').trigger('blur');
});

$(document).on('click', '.tags-field', function(event) {
	$(this).find('span[contenteditable]').focus();
});

$(document).on('click', '.tags-field-input', function(event) {
	event.stopPropagation();
});

$(document).on('click', '.tags-field-tag', function(event) {
	if (!event.shiftKey) {
		$('.tags-field-selected').trigger('blur');
	}
	$(this).trigger('focus', event.shiftKey);
	event.stopPropagation();
});

$(document).on('keydown', function(event) {
	var src = $(event.srcElement);
	if (event.keyCode == 8 && src.text() == '') {
		src.prevAll('.tags-field-tag').eq(0).trigger('focus');
	}
	else if (event.keyCode == 37) {
		if (event.shiftKey) {
			src.prevUntil('.tags-field-input').trigger('togglefocus');
		}
		src.prevAll('.tags-field-input').eq(0).trigger('focus', event.shiftKey);
	}
	else if (event.keyCode == 39) {
		if (event.shiftKey) {
			src.nextUntil('.tags-field-input').trigger('togglefocus');
		}
		src.nextAll('.tags-field-input').eq(0).trigger('focus', event.shiftKey);
	}
});

$(document).on('keydown keyup', '.tags-field-phantom', function(event) {
	if ($(this).text() != '' || event.keyCode == 8) {
		$('.tags-field-selected').remove();
		$(this).prevAll('.tags-field-input:not(.tags-field-phantom)').eq(0).remove();
		$(this).nextAll('.tags-field-input').eq(0).remove();
		$(this).removeClass('tags-field-phantom');
		$(this).css('position', 'static');
	}
	event.stopPropagation();
});

$(document).on('focus', '.tags-field', function(event) {
	$(this).addClass('focused');
});

$(document).on('blur', '.tags-field', function(event) {
	var field = $(this);
	setTimeout(function() {
		if (!$('.tags-field-selected').size() && !field.find(':focus').size()) {
			field.removeClass('focused');
		}
	}, 10);
});

$(document).on('focus', '.tags-field-input:not(.tags-field-phantom)', function(event, preserveSelection) {
	if (!preserveSelection) {
		$('.tags-field-phantom').remove();
		$('.tags-field-selected').trigger('blur');
	}
});

$(document).on('focus', '.tags-field-tag', function(event, preserveSelection) {
	$('.tags-field-phantom').remove();
	$(this).prevAll('.tags-field-input').eq(0).clone(true).insertBefore(this).css({
		'position': 'absolute',
		'left': $(this).position().left - 9999,
		'top': $(this).position().top + 0,
	}).trigger('focus', preserveSelection).addClass('tags-field-phantom');
	$(this).addClass('tags-field-selected');
});

$(document).on('togglefocus', '.tags-field-tag', function(event) {
	if ($(this).hasClass('tags-field-selected')) {
		$(this).trigger('blur');
	}
	else {
		$(this).trigger('focus');
	}
});

$(document).on('blur', '.tags-field-tag', function(event) {
	$(this).removeClass('tags-field-selected');
});

/** --------------------------------------------------------- **/

$(function() {
	$('[data-typeahead]').data('typeahead-renderRow', function(data) {
		return '<li>'+data.tag+'</li>';
	});
});

$(document).on('keyup', '[data-typeahead]', function(event) {
	// Localize Variables
	var input = $(this);
	var popover = input.data('typeahead-popover') || $('<div class="ta-typeahead"><ul class="ta-list"></ul><i class="icon-undo"></i></div>').hide().appendTo(document.body);
	input.data('typeahead-popover', popover);

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