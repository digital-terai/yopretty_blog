/***************************************************/
/* PB Suggest                                      */
/* Version: 1.0                                    */
/* Author: Paolo Bonacina                          */
/***************************************************/

/*
reads from input elements and displays a dropdown with suggestions
clicking the dropdown copies the selected row to the input with optional form submit

Typical usage:

$(#input).pbsSuggest({key: value, key: value, key: value, ... });

Available parameters:
	call:				REQUIRED STRING		Api to call. It must return an object of key-value pairs. The key will be copied to the input when the user selects a suggestion. The value is the text displayed to the user.
	token:				STRING				Cross-site-request-forgery token sent to the api.
	count:				INTEGER				Max number of results to display.
	min_chars:			INTEGER				Minimum number of characters needed to show suggestions.
	submit:				BOOL				Whether to automatically submit the form the input is in when the user selects a suggestion.
	filters:			ARRAY				key-value pairs sent to the api to dynamically change your api call.
	target:				STRING				A jQuery selector to an input that will accept the result in place of the input the user is tiping into.
	text_start:			STRING				Text displayed when clicking inside the input before typing.
	text_search:		STRING				Text displayed while searching results.
	text_no_results:	STRING				Text displayed when the api did not return any item.
});

The plugin makes a POST call and sends automatically the following parameters:
	search_text:		STRING				The user input,
	count:				INTEGER				Max number of results to display,
	filters:			ARRAY				Key-value pairs to dynamically change your api call
	_token:				STRING				For laravel applications
The plugin expects the call to return results in this format:

	{
		result1key: result1value,
		result2key: result2value,
		result3key: result3value
	}

*/


/*	constants	*/
// core variables
var DEFAULT_COUNT = 5;							// number of entries to display
var DEFAULT_MIN_CHARS = 5;						// minimum number of characters in string to start the search
var DEFAULT_SUBMIT = false;						// whether to trigger the submit of the form the input is in once the user clicks a suggestion
var DEFAULT_FILTERS = [];						// whether to trigger the submit of the form the input is in once the user clicks a suggestion

// helper texts
var DEFAULT_TEXT_START = 'Start typing to search.';
var DEFAULT_TEXT_SEARCH = 'Searching...';
var DEFAULT_TEXT_NO_RESULTS = 'No results.';

var default_config = {
	count:				DEFAULT_COUNT,
	min_chars:			DEFAULT_MIN_CHARS,
	submit:				DEFAULT_SUBMIT,
	filters:			DEFAULT_FILTERS,
	text_start:			DEFAULT_TEXT_START,
	text_search:		DEFAULT_TEXT_SEARCH,
	text_no_results:	DEFAULT_TEXT_NO_RESULTS
};

var cursor = 0;

/*	variables	*/
var result_count;								// number of entries found

// returns a config value, or its default
function pbsConfigDefault(var_value, default_value) {
	return (var_value)? var_value : default_value;
}

// used to print errors in console
function pbsError(content, check) {
	check = check || false;
	if (!check) {
		console.error('PB Suggest - ERROR:');
		console.error(content);
	}
}

// reads a configuration object and fires errors for required parameters
function pbsReadConfig(config_object) {
	var config = $.extend(default_config, config_object);

	pbsError('Missing API address.', config.call);

	return config;
}

// when the user clicks a suggested item, the item is copied to the input
function pbsHandleLinks(target) {
	target = target || false;
	$('.pbs-key').click(function(e) {
		e.preventDefault();
		if (target)
			input = $(target);
		else
			input = $(this).closest('.pbs-wrapper').find('.pbs-input');
		input.val($(this).attr('href'));
		if (input.data('submit'))
			input.closest('form').submit();
		input.blur();
	});
}

function pbsWrap(current, min, max) {
	current = (current > max)? min: current;
	current = (current < min)? max: current;
	return current;
}

function pbsClamp(current, min, max) {
	return Math.min(Math.max(min, current),max);
}

// clears the suggest results and adds generic content
function pbsMessage(text, target) {
	target.html('');
	target.html('<div class="pbs-standard">'+text+'</div>');
}

// clears the suggest results and adds new ones
function pbsRender(data, target, config) {
	target.html('');
	$.each(data, function(k, v) {
		$('<a class="pbs-key">')
			.attr('href', k)
			.html(v)
			.appendTo(target);
	});
	pbsHandleLinks(config.target);
}

function pbsHighlight(index, target) {
	var entries = target.find('.pbs-key');
	entries.removeClass('active').eq(index).addClass('active');
	target.scrollTop(target.scrollTop() + entries.eq(index).position().top - target.innerHeight()/2);
}

function pbsSelect(target) {
	target.find('.active').click();
}

// functionality initialization
jQuery.fn.extend({
    pbsSuggest: function(config_object) {
		// read configuration object and fire errors
		var config = pbsReadConfig(config_object);

		this.each(function() {
			var elem = $(this);

			var wrapper = $('<div class="pbs-wrapper"></div>');
			elem.before(wrapper).appendTo(wrapper);

			// add class to input
			elem.addClass('pbs-input');
			elem.data('submit', config.submit);

			// create drop-down
			var results_container = $('<div class="pbs-results"></div>');
			elem.after(results_container);
			elem.data('target', results_container);

			pbsMessage(config.text_start, elem.data('target'));

			// prevent sending the form with enter
			elem.keydown(function(e) {
				if (e.key == 'Enter')
					e.preventDefault();
			});

			// add event to user input
			elem.keyup(function (e) {
				if ($.inArray(e.key, ['ArrowUp', 'ArrowDown']) != -1) {
					// the key is an arrow or an enter and we need to move the cursor
					if (e.key == 'ArrowUp') cursor--;
					if (e.key == 'ArrowDown') cursor++;
					cursor = pbsClamp(cursor, 0, result_count - 1);
					pbsHighlight(cursor, elem.data('target'));
				}
				else if (e.key == 'Enter') {
					// call click event for selected item
					pbsSelect(elem.data('target'));
				}
				else {
					var search_text = elem.val().trim();

					if (config.target) {
						input = $(config.target);
						input.val('');
					}


					if (search_text.length < config.min_chars)
						return false;

					if (search_text != '') {
						pbsMessage(config.text_search, elem.data('target'));
						$.ajax({
							type: 'POST',
							url: config.call,
							data: {
								search_text: search_text,
								count: config.count,
								filters: config.filters,
								_token: config.token
							},
							dataType : 'json',
							success : function(response) {
								if (Object.keys(response).length) {
									pbsRender(response, elem.data('target'), config);
									result_count = Object.keys(response).length;
									cursor = 0;
									pbsHighlight(cursor, elem.data('target'));
								}
								else
								pbsMessage(config.text_no_results, elem.data('target'));
							},
							error : function(response) {
								pbsError(response);
							}
						});
						return true;
					}
					else
					return false;
				}
			});
		});
    }
});
