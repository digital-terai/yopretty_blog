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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/lara-file-manager.js":
/*!*******************************************!*\
  !*** ./resources/js/lara-file-manager.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var $modal = $('#filemanager');
  /*
  * When the user clicks on upload button, open the modal
  * with input name and current value
  */

  $('.filemanager-select').on('click', function (e) {
    e.preventDefault();
    $modal.modal('show');
    var inputName = $(this).data('input');
    var inputValue = $('input[name=' + inputName + ']').val(); // If 'inputValue' value is != 0, open library tab

    if (inputValue != 0) {
      $('#file-manager-list').click();
    } // Set modal hidden input values


    $('input[name=file-input]', $modal).val(inputName);
    $('input[name=file-value]', $modal).val(inputValue);
  });
  /*
  * Tab upload, uploadifive method
  */

  $('input[name=upload-input]', $modal).uploadifive({
    'auto': true,
    'queueID': 'queue-modal',
    'uploadScript': urlAjaxHandlerCms + 'filemanager/upload',
    'onAddQueueItem': function onAddQueueItem(file) {
      this.data('uploadifive').settings.formData = {
        '_token': $('[name=_token]').val()
      };
    },
    'onUploadComplete': function onUploadComplete(file, data) {
      var responseObj = jQuery.parseJSON(data);
      var mediaType = responseObj.data; // Set media id in modal hidden value

      $('input[name=file-value]', $modal).val(responseObj.id); // Switch to 'library' tab

      $('#file-manager-list').click(); // Empty the content of the sidebar

      $('#sidebar-content').empty();
    }
  });
  /*
  * When the user clicks on 'library' tab, load all images
  */

  $('#file-manager-list').on('click', function (e) {
    var input_obj = $('.filemanager-select').data("input");
    var media_obj_id = parseInt($('input[name=' + input_obj + ']').val()) ? parseInt($('input[name=' + input_obj + ']').val()) : '';
    var request_url = "".concat(urlAjaxHandlerCms, "filemanager/list/").concat(media_obj_id);
    $('#tab-images-gallery').load(request_url, function () {
      $('.modal-footer', $modal).removeClass('hidden');
      var fileValue = $('input[name=file-value]').val(); // If user is in edit mode, set media as active and load sidebar

      if (fileValue != 0) {
        $('#media-id-' + fileValue).addClass('is-active');
        $('#sidebar-content').load(urlAjaxHandlerCms + 'filemanager/edit/' + fileValue);
      }
    });
  });
  /*
  * When the user select an image, set modal hidden value and load sidebar
  */

  $(document).on('click', '.filemanager-list a', function (e) {
    e.preventDefault(); // Remove all 'is-active' classes

    $('.filemanager-list a').removeClass('is-active'); // Set modal hidden value with media id

    $('input[name=file-value]', $modal).val($(this).data('id')); // Load sidebar

    $('#sidebar-content').load(urlAjaxHandlerCms + 'filemanager/edit/' + $(this).data('id')); // Set 'is-active' class

    $(this).addClass('is-active');
  });
  /*
  * Sidebar: update image data
  */

  $(document).on('submit', '#filemanager-edit-form', function (e) {
    e.preventDefault();
    var form = $(this); // Make ajax request to edit media data

    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data: form.serialize(),
      dataType: 'json',
      success: function success(response) {
        $.notify(response.message, 'success');
      },
      error: function error(response) {
        $.notify('Error.');
      }
    });
  });
  /*
  * When the user clicks resets button, remove current active and reset hidden input value
  */

  $('.reset-image', $modal).on('click', function (e) {
    e.preventDefault(); // Remove all 'is-active' classes

    $('.filemanager-list a').removeClass('is-active'); // Set modal hidden value as 0

    $('input[name=file-value]', $modal).val(0);
  });
  /*
  * When the user confirm an image from filemanager,
  * set image id as new value in admin form input and close the modal
  */

  $('.confirm-image', $modal).on('click', function (e) {
    e.preventDefault(); // Set admin form input value

    $('input[name=' + $('input[name=file-input]', $modal).val() + ']').val($('input[name=file-value]', $modal).val()); // Close modal

    $modal.modal('hide');
  });
  /*
   * When the user close the modal, reset sidebar and loader.
   */

  $('#filemanager').on('hidden.bs.modal', function () {
    // Reset modal tabs to upload
    $('#file-manager-upload').click(); // Reset loading html

    $('#tab-images-gallery').html("<div class=\"loading text-center\">\n      <i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i>\n      <span class=\"sr-only\">Loading...</span>\n    </div>"); // Reset sidebar content

    $('#sidebar-content').html('');
  });
});

/***/ }),

/***/ 6:
/*!*************************************************!*\
  !*** multi ./resources/js/lara-file-manager.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/asperti/web/magutti/maguttiCms/resources/js/lara-file-manager.js */"./resources/js/lara-file-manager.js");


/***/ })

/******/ });