/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
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
    $('#btn-newsletter-subscribe').click(function (e) {
      e.preventDefault(); //showWait();

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
  } // checkboxes and radio


  function initCheckboxes() {
    $('input[type="checkbox"], input[type="radio"]').change(function () {
      var elem = $(this);

      if (elem.is('input[type="radio"]')) {
        $('input[type="radio"][name="' + elem.attr('name') + '"]').each(function () {
          updateCheckbox($(this));
        });
      } else updateCheckbox($(this));
    }).each(function () {
      updateCheckbox($(this));
    });
  }

  function updateCheckbox(elem) {
    var checked = elem.is(':checked');
    if (checked) elem.closest('.form-checkbox, .form-radio').addClass('checked');else elem.closest('.form-checkbox, .form-radio').removeClass('checked');
  }

  function handleLightBox() {
    $(".lightbox").fancybox({});
  }

  function handleWow() {
    window.wow.init({
      mobile: false,
      // default
      live: false // default

    });
  }

  function scrollTo(hash) {
    var margin_top = $("nav").outerHeight();
    var elem_top = $(hash).offset().top;
    $('html, body').stop().animate({
      'scrollTop': elem_top - margin_top
    }, 500);
  }

  function handleScrollTo() {
    $('.scroll-to').click(function (e) {
      e.preventDefault();
      scrollTo($(this).attr('href'));
    });

    if (window.location.hash) {
      scrollTo(window.location.hash);
    }
  }

  function handleGhostInputs() {
    $('.form-ghost').each(function () {
      var elem = $(this);
      elem.data('original', elem.val());
    }).blur(function (e) {
      e.preventDefault();
      var elem = $(this);

      if (elem.val() != elem.data('original')) {
        var id = $(this).data('id');
        var model = $(this).data('model');
        var field = $(this).data('field');
        var value = $(this).val();
        $.ajax({
          type: 'POST',
          url: '/api/update-ghost',
          data: {
            id: id,
            model: model,
            field: field,
            value: value,
            _token: Laravel.csrfToken
          },
          dataType: 'json',
          success: function success(response, status) {
            elem.data('original', value);
            $.each(response.alerts, function () {
              $.smkAlert({
                text: this.text,
                type: this.type,
                time: this.time
              });
            });
          },
          error: function error(response) {
            $.smkAlert({
              text: trans('website.ghost.error'),
              type: 'danger',
              time: 5
            });
          }
        });
        return true;
      }
    });
  }

  return {
    init: function init() {
      handleBootstrap();
      handleNewsletter();
      handleLightBox();
      handleWow();
      handleScrollTo();
      handleGhostInputs();
      initCheckboxes();
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
          error: function error(response) {//console.log(response.errors.email);
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

/***/ 1:
/*!***********************************!*\
  !*** multi ./resources/js/app.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/asperti/web/magutti/maguttiCms/resources/js/app.js */"./resources/js/app.js");


/***/ })

/******/ });