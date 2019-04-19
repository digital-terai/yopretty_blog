/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 61);
/******/ })
/************************************************************************/
/******/ ({

/***/ 13:
/***/ (function(module, exports) {

window.App = function () {
				function handleBootstrap() {
								/*Bootstrap Carousel*/
								$('.carousel').carousel({
												interval: 5000,
												pause: 'hover'
								});

								/*Tooltips*/
								$('.tooltips').tooltip();
								$('.tooltips-show').tooltip('show');
								$('.tooltips-hide').tooltip('hide');
								$('.tooltips-toggle').tooltip('toggle');
								$('.tooltips-destroy').tooltip('destroy');

								/*Popovers*/
								$('.popovers').popover();
								$('.popovers-show').popover('show');
								$('.popovers-hide').popover('hide');
								$('.popovers-toggle').popover('toggle');
								$('.popovers-destroy').popover('destroy');
				}

				function handleNewsletter() {
								var msg = '';
								$('#form-newsletter').submit(function (e) {
												e.preventDefault();
												//showWait();
												$.ajax({
																type: 'POST',
																url: urlAjaxHandler + "/api/newsletter",
																data: $("#form-newsletter").serialize(),
																dataType: 'json',
																success: function success(response) {
																				var msgHtml = '';
																				if (response.status == 'ok') {
																								msgHtml += '<h4>' + response.msg + '</h4>';
																				} else {
																								$.each(response.errors, function (key, value) {
																												msgHtml += '<h4>' + value[0] + '</h4>'; //showing only the first error.
																								});
																				}
																				updateModalAlertMsg(msgHtml);
																},
																error: function error(response) {
																				updateModalAlertMsg('Error');
																}
												});
								});
				}

				function handleLightBox() {
								$(".lightbox").fancybox({});
				}

				function handleWow() {
								window.wow.init({
												mobile: false, // default
												live: false // default
								});
				}

				function handleScrollTo() {
								$('.scroll-to').click(function (e) {
												e.preventDefault();
												var margin_top = $("nav").outerHeight();
												var elem_top = $($(this).attr('href')).offset().top;
												$('html, body').stop().animate({ 'scrollTop': elem_top - margin_top }, 500);
								});
				}

				return {
								init: function init() {
												handleBootstrap();
												handleNewsletter();
												handleLightBox();
												handleWow();
												handleScrollTo();
								},
								formValidation: function formValidation(selector) {
												var msg = '';
												$('#' + selector).submit(function (event) {
																event.preventDefault();

																$.ajax({
																				type: 'POST',
																				url: urlAjaxHandler + '/api/' + selector,
																				data: $('#' + selector).serialize(),
																				dataType: 'json',
																				success: function success(response) {
																								if (response.status == 'ok') {
																												$('#' + selector).hide();
																												$('#response').show().text(response.msg);
																								} else {
																												$.each(response.errors, function (key, value) {
																																$('[name="' + key + '"]').addClass('error');
																												});

																												$('html, body').animate({
																																scrollTop: $('#' + selector).offset().top - $('nav').height()
																												}, 1200, 'swing');
																								}
																				},
																				error: function error(response) {
																								//console.log(response.errors.email);
																				}
																});
												});
								}
				};
}();

/******************************** MODAL ************************/
function updateModalAlertMsg($htmlContent) {
				bootbox.alert($htmlContent, function (result) {});
}

function updateModalBoxMsg($htmlContent) {
				bootbox.confirm($htmlContent, function (result) {});
}

/*********************************  localize *********************/
function trans(keystring) {
				var key_array = keystring.split('.');
				var temp_localization = JS_LOCALIZATION;
				$.each(key_array, function () {
								temp_localization = temp_localization[this];
				});
				if (typeof temp_localization == 'string') return temp_localization;else return keystring;
}

/***/ }),

/***/ 61:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(13);


/***/ })

/******/ });