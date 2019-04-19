/*
	PB-OVERLAY

	JQuery plugin to prevent user interaction during lenghty API calls.

	##### SETUP #####
	Add jquery.pb-overlay.js and pb-overlay.css to your html.
	Initialize the overlay with:

	var MyOverlay = new Overlay();


	##### SETTING CONTENTS
	There's a different function to set each element:

	MyOverlay.changeIcon(classes);
	This function resets the icon to its default state and adds the specified classes as in $.addClass().
	Classes should be space-separated.
	To hide the icon, set classes to false;

	MyOverlay.changeText(text, classes);
	This works exactly like changeIcon(), but also sets the text.
	To hide the text, set the text argument to false;

	MyOverlay.changeButtons(buttons);
	This function allows you to create a new set of buttons by passing an array of objects with the following keys:
	action, text, classes, hide_on_click, target

	Action should be a url string or javascript function.

	Text and classes work exactly like in changeText().
	Hide_on_click allows you to specify if the overlay must be closed on click.
	Target refers to the target for a normal anchor like "_blank".
	In this case, setting action or text to false hides the button altogether.
	Here's an example of array

	[
		{
			action: function() {alert('i\'m a button that opens an alert')},
			text: 'Show alert',
			classes: 'btn btn-primary',
			hide_on_click: false,
			target: ''
		}
		{
			action: 'http://www.example.com',
			text: 'Go to website',
			classes: 'btn btn-secondary',
			hide_on_click: true,
			target: '_blank'
		}
	]


	##### SHOW AND HIDE THE OVERLAY
	There are two easy functions:

	MyOverlay.hide();
	MyOverlay.show();


	##### DISABLING ANIMATIONS
	If, for any reason, you need to disable the animation you can use two wrappers:

	MyOverlay.enableAnimations();
	MyOverlay.disableAnimations();


	##### CHECKING THE OVERLAY
	You can detect if the overlay is shown with:

	MyOverlay.isVisible();


	##### USER-DEFINED MARKUP
	pb-overlay creates all the markup it needs on its own, but if you want you can define a custom overlay with other classes and elements.
	Use this html template to customize your overlay

	<div id="pbov_main">
		<div id="pbov_background"></div>
		<div id="pbov_wrapper">
			<i id="pbov_icon" class="fa fa-4x"></i>
			<div id="pbov_text"></div>
			<a href="" id="pbov_button" class="btn btn-lg"></a>
		</div>
	</div>
*/

function Overlay() {
	/*
	Wrapper for console.error.
		string: string
	*/
	this.logError = function(string) {
		console.error('PB Overlay: ' + string);
	};

	/*
	Checks if a jQueyr element exists
		selector: string (jQuery selector)
	*/
	this.checkElement = function(selector) {
		if ($(selector).length)
			return $(selector);
		else {
			if (selector != '#pbov_main')
				this.logError('Missing element '+selector);
			return false;
		}
	};

	/*
	Markup used to create the overlay if the user does not define his own.
	*/
	var DEFAULT_MARKUP = '<div id="pbov_main"><div id="pbov_background"></div><div id="pbov_wrapper"><i id="pbov_icon" class="fa"></i><div id="pbov_text" class=""></div></div></div>';
	if (!this.checkElement('#pbov_main')) {
		$('body').append(DEFAULT_MARKUP);
	}

	var SELF = this;

	/*
	Constants for quick access
	*/
	var OV_ELEMENT = this.checkElement('#pbov_main');
	var OV_ICON = this.checkElement('#pbov_icon');
	var OV_TEXT = this.checkElement('#pbov_text');
	var OV_WRAPPER = this.checkElement('#pbov_wrapper');

	/*
	Used to save and restore user-defined classes
	*/
	var DEFAULT = {
		'icon': OV_ICON.attr('class'),
		'text': OV_TEXT.attr('class')
	};

	var IS_ANIMATED = true;
	var FADE_TIME = 500;

	/*
	Show or hide any element. Shows or hides the whole overlay if no element is specified
		element: jQuery element
	*/
	this.show = function(element) {
		element = element || OV_ELEMENT;
		if (IS_ANIMATED)
			element.fadeIn(FADE_TIME);
		else
			element.show();
	}
	this.hide = function(element) {
		element = element || OV_ELEMENT;
		if (IS_ANIMATED)
			element.fadeOut(FADE_TIME);
		else
			element.hide();
	}

	/*
	Restores the icon to the default classes
	*/
	this.resetIcon = function() {
		OV_ICON.attr('class', DEFAULT.icon);
	}
	/*
	Adds classes to the icon
		classes: string
	*/
	this.setIcon = function(classes) {
		OV_ICON.addClass(classes);
	}

	/*
	Restores the text to the default classes
	*/
	this.resetText = function() {
		OV_TEXT.attr('class', DEFAULT.text);
	}
	/*
	Set the text and adds classes to the text
		text: string
		classes: string
	*/
	this.setText = function(text, classes) {
		OV_TEXT.text(text);
		OV_TEXT.addClass(classes);
	}

	/*
	Creates and returns a button
		action: string (url) or function
		text: string
		classes: string
		hide_on_click: boolean
		target: string
	*/
	this.createButton = function(action, text, classes, hide_on_click, target) {
		instance = $('<a href="" class="pbov_button" style="display: none;"></a>');

		if (typeof action === 'string') {
			instance.attr('href', action);
			if (hide_on_click) {
				instance.click(function() {
					setTimeout(function() {
						OV_ELEMENT.hide();
					}, 100);
				});
			}
		}
		else if (typeof action === 'function') {
			instance.attr('href', '');
			instance.click(function(e) {
				e.preventDefault();
				action.call();
				if (hide_on_click) {
					setTimeout(function() {
						OV_ELEMENT.hide();
					}, 100);
				}
			});
		}
		instance.text(text);
		instance.addClass(classes);
		instance.attr('target', target);

		return instance;
	};

	/*
	Wappers to enable and disable animations on all other functions
	*/
	this.enableAnimations = function() {IS_ANIMATED = true;}
	this.disableAnimations = function() {IS_ANIMATED = false;}

	/*
	Returns true if the overlay is currently displayed
	*/
	this.isVisible = function() {return OV_ELEMENT.is(':visible');}

	/*
	End-user function to change the icon
		classes: string
	*/
	this.changeIcon = function(classes) {
		// default values
		classes = classes || '';

		if (classes) {
			this.hide(OV_ICON);
			if (IS_ANIMATED && OV_ICON.is(":visible")) {
				setTimeout(function() {
					SELF.resetIcon();
					SELF.setIcon(classes);
				}, FADE_TIME);
			}
			else {
				SELF.resetIcon();
				SELF.setIcon(classes);
			}
			this.show(OV_ICON);
		}
		else
			this.hide(OV_ICON);
	}
	/*
	End-user function to change the text
		text: string
		classes: string
	*/
	this.changeText = function(text, classes) {
		// default values
		text = text || '';
		classes = classes || '';

		if (text) {
			this.hide(OV_TEXT);
			if (IS_ANIMATED && OV_TEXT.is(":visible")) {
				setTimeout(function() {
					SELF.resetText();
					SELF.setText(text, classes);
				}, FADE_TIME);
			}
			else {
				SELF.resetText();
				SELF.setText(text, classes);
			}
			this.show(OV_TEXT);
		}
		else
			this.hide(OV_TEXT);
	}
	/*
	End-user function to change the buttons
	Buttons is an array of objects with the following keys:
		action: string (url) or function
		text: string
		classes: string
		hide_on_click: boolean
		target: string
	*/
	this.changeButtons = function(buttons) {
		// delete all buttons
		// create a button for each provided set of variables
		SELF.hide($('.pbov_button'));
		if (IS_ANIMATED) {
			setTimeout(function() {
				OV_WRAPPER.find('.pbov_button').remove();
				$.each(buttons, function() {
					_button = this;

					// default values
					action = _button.action || '';
					text = _button.text || '';
					classes = _button.classes || '';
					hide_on_click = _button.hide_on_click || false;
					target = _button.target || '';

					button = SELF.createButton(action, text, classes, hide_on_click, target);
					OV_WRAPPER.append(button);
				});
				SELF.show($('.pbov_button'));
			}, FADE_TIME);
		}
		else {
			OV_WRAPPER.find('.pbov_button').remove();
			$.each(buttons, function() {
				_button = this;

				// default values
				action = _button.action || '';
				text = _button.text || '';
				classes = _button.classes || '';
				hide_on_click = _button.hide_on_click || false;
				target = _button.target || '';

				button = SELF.createButton(action, text, classes, hide_on_click, target);
				OV_WRAPPER.append(button);
			});
			SELF.show($('.pbov_button'));
		}
	}
}

window.Overlay = Overlay;
