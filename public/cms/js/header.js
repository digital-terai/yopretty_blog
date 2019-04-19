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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/header.js":
/*!********************************!*\
  !*** ./resources/js/header.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var SIZE_M = 768;
var SIZE_L = 992;
var SIZE_H = 1200;
var ANIMATION_TIMING = 300;
var Header = {
  query_m: window.matchMedia('(min-width: ' + SIZE_M + 'px)'),
  query_l: window.matchMedia('(min-width: ' + SIZE_L + 'px)'),
  query_h: window.matchMedia('(min-width: ' + SIZE_H + 'px)'),
  // navbar
  initNavbar: function initNavbar() {
    $('.nav-toggle').on('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var target = $(this).attr('href');

      if ($(target).hasClass('vertical')) {
        $(target).toggleClass('open');

        if (!Header.query_m.matches) {
          $('.nav').not(target).slideUp();
        }
      } else {
        if (!Header.query_m.matches) {
          $('.nav').not(target).removeClass('open');
          $(target).slideToggle(ANIMATION_TIMING);
        }
      }
    });
    $('.nav-sub-toggle').on('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).closest('li').siblings().find('.nav-sub').slideUp(ANIMATION_TIMING);
      $(this).siblings('.nav-sub').slideToggle(ANIMATION_TIMING);
    });
    $('html').on('click', function () {
      $('.nav-sub-toggle').siblings('.nav-sub').slideUp(ANIMATION_TIMING);

      if (!Header.query_m.matches) {
        $('.nav').each(function () {
          if ($(this).hasClass('vertical')) {
            if ($(this).hasClass('open')) {
              $(this).removeClass('open');
            }
          } else $(this).slideUp(ANIMATION_TIMING);
        });
      }
    });
    $(window).on('resize', function () {
      if (Header.query_m.matches) {
        $('.nav').css('display', '');
      }
    });
  }
};
$(function () {
  Header.initNavbar();
});

/***/ }),

/***/ 5:
/*!**************************************!*\
  !*** multi ./resources/js/header.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/asperti/web/magutti/maguttiCms/resources/js/header.js */"./resources/js/header.js");


/***/ })

/******/ });