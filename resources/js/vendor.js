/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// require('jquery-colorbox');
require('@fancyapps/fancybox');
require('owl.carousel');
require('smokejs/dist/js/smoke.min.js');
const WOW = require('wowjs'); window.wow = new WOW.WOW({ live: false });
window.Cookies = require('js-cookie');
window.bootbox = require('bootbox');

require('./gmaps.js');
require('./jquery.maCookieEu.js');
require('../plugins/jquery.pb-filter.js');
require('../plugins/pb-suggest/jquery.pb-suggest.js');
require('../plugins/pb-overlay/jquery.pb-overlay.js');
