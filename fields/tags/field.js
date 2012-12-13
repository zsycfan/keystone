function token(data) {
	return $('<input type="submit" disabled class="token" data-token data-value="'+data.value+'" value="'+data.label+'" />').get(0)
}

$(document).on('click', '.ta-list a', function(e) {

	// Get the window selection
	var sel = window.getSelection();

	// Get the current cursor position
	var currentRange = sel.getRangeAt(0);

	// Clone the current range so we can select the text content to be
	// replaced by the token and then place the cursor after the inserted
	// element.
	var newRange = currentRange.cloneRange();

	// Grab the data from the selected token
	var tag = $(this).data('data');

	// Get the input element we're associated with
	var input = $(this).closest('.ta-token').data('token-input');

	// Create the token element
	// var placeholder = $('<input type="submit" disabled class="token" name="'+input.attr('data-token-name')+'" data-token data-value="'+tag.id+'" data-id="'+tag.id+'" value="'+tag.name+'" src="/keystone/img/spacer.gif" size="" />').get(0);
	var placeholder = token({
		'value': 'tags:'+tag.id,
		'label': tag.name
	});

	// Insert the token
	currentRange.insertNode(placeholder);

	// Select the text prior to the inserted token and delete it
	newRange.setStart(newRange.startContainer, newRange.startContainer.textContent.replace(/^(.*\s)?.*$/, '$1').length);
	newRange.setEndBefore(placeholder);
	newRange.deleteContents();

	// Place the cursor after the inserted element so we can keep typing
	newRange.setEndAfter(placeholder);
	newRange.collapse(false);
	sel.removeAllRanges();
	sel.addRange(newRange);

	return false;
});

$(function() {
	$('[data-token-field]').data('token-renderRow', function(tag) {
		return '<li><a href="#" data-data="'+JSON.stringify(tag).replace(/"/g,'&quot;')+'">'+tag.name+'</a></li>';
	});
});

$(document).on('keydown', '[data-token-field]', function(event) {
	var input = $(this);
	var popover = input.data('token-popover');

	// Check that popover exists
	if (!popover) {
		return true;
	}

	// Check key
	if (event.keyCode == 38 /* up */ || event.keyCode == 40 /* down */) {
		var index = popover.find('.ta-list .active').removeClass('active').index();
		index += event.keyCode == 38? -1 : 1;
		popover.find('.ta-list li').eq(index).addClass('active');
		return false;
	}

	else if (event.keyCode == 13 /* return */) {
		popover.find('.ta-list .active a').trigger('click');
		return false;
	}

	return true;
});

$(document).on('keyup', '[data-token-field]', function(event) {
	// Check key
	if (event.keyCode == 38 /* up */ || event.keyCode == 40 /* down */) {
		return true;
	}
	else if (event.keyCode == 13 /* return */) {
		return false;
	}

	// Localize Variables
	var input = $(this);
	var popover = input.data('token-popover') || $('<div class="ta-token"><ul class="ta-list"></ul></div>').hide().appendTo(document.body);
	input.data('token-popover', popover);
	popover.data('token-input', input);

	// Localize api methods
	var renderRow = input.data('token-renderRow');

	// Remove the popover if there is nothing to display
	if (!input.val() && !input.text()) {
		return popover.fadeOut();
	}

	// Apply styling and fade it in
	popover.css({
		// '-webkit-transition': 'all 0.5s',
		'position':'absolute',
		'top': window.getSelection().getRangeAt(0).getClientRects()[0].top + 5 + window.getSelection().getRangeAt(0).getClientRects()[0].height + $(document.body).scrollTop(),
		'left': window.getSelection().getRangeAt(0).getClientRects()[0].left + window.getSelection().getRangeAt(0).getClientRects()[0].width - 7,
		'z-index': 9999,
		'background': 'rgba(255,255,255,0.9)',
		'color': '#fff',
		'box-shadow': '0 2px 5px rgba(0,0,0,0.2)',
		'padding': 2,
		'border-radius': 4,
		'min-width': 200
	}).fadeIn();

	// Fetch the data for the popover
	$.get(input.data('token-src'), function(data) {

		// Find our list of results
		var list = popover.find('.ta-list');
		var children = list.find('> *');
		var sorted = [];

		// Mark everything for removal
		children.attr('data-token-remove', true);

		// Render each row
		for (var rowIndex=0; rowCount=data.length,rowIndex<rowCount; rowIndex++) {
			var row = $(renderRow(data[rowIndex]));

			// If the row exists, touch it so it's not removed in the upcoming
			// cleanup routine
			var matched = list.find('> *').filter(function(index) {
				return $(this).html() == row.html();
			}).removeAttr('data-token-remove');

			// If the element is already in the DOM then we'll just note the
			// index so we can sort it later.
			if (matched.length != 0) {
				sorted.push(matched);
			}

			// If nothing matched add the new row into the dom and note it's
			// sort index
			else {
				list.append(row.hide());
				row.slideDown(0);
				sorted.push(row);
			}
		}

		// Remove rows that haven't been touched
		list.find('[data-token-remove]').slideUp(0, function() {
			$(this).remove();
		});

		// Resort the list using the latest returned indexes
		for (var sortIndex=0; sortCount=sorted.length,sortIndex<sortCount; sortIndex++) {
			list.append(sorted[sortIndex]);
		}
	}, 'json');
});

$(document).on('focus', '[data-token-field]', function(event) {
	var input = $(this);
	if (input.val()) {
		input.trigger('keyup');
	}
});

$(document).on('blur', '[data-token-field]', function(event) {
	var popover = $(this).data('token-popover');
	if (popover) {
		popover.fadeOut();
	}
});