var SIZE_M = 768;
var SIZE_L = 992;
var SIZE_H = 1200;

var ANIMATION_TIMING = 300;

var Header = {
	query_m: window.matchMedia('(min-width: '+SIZE_M+'px)'),
	query_l: window.matchMedia('(min-width: '+SIZE_L+'px)'),
	query_h: window.matchMedia('(min-width: '+SIZE_H+'px)'),
	// navbar
	initNavbar: function() {
		$('.nav-toggle').on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			let target = $(this).attr('href');
			if ($(target).hasClass('vertical')) {
				$(target).toggleClass('open');
				if (!Header.query_m.matches) {
					$('.nav').not(target).slideUp();
				}
			}
			else {
				if (!Header.query_m.matches) {
					$('.nav').not(target).removeClass('open');
					$(target).slideToggle(ANIMATION_TIMING);
				}
			}
		});
		$('.nav-sub-toggle').on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).closest('li').siblings().find('.nav-sub').slideUp(ANIMATION_TIMING);
			$(this).siblings('.nav-sub').slideToggle(ANIMATION_TIMING);
		});
		$('html').on('click', function() {
			$('.nav-sub-toggle').siblings('.nav-sub').slideUp(ANIMATION_TIMING);
			if (!Header.query_m.matches) {
				$('.nav').each(function() {
					if ($(this).hasClass('vertical')) {
						if ($(this).hasClass('open')) {
							$(this).removeClass('open');
						}
					}
					else
						$(this).slideUp(ANIMATION_TIMING);
				});
			}
		});
		$(window).on('resize', function() {
			if (Header.query_m.matches) {
				$('.nav').css('display', '');
			}
		});
	}
};

$(function() {
	Header.initNavbar();
});
