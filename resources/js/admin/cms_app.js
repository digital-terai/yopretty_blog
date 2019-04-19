/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//import Popper from 'popper.js';
//window.Popper = Popper;
require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('flash', require('./../components/Flash'));
Vue.component('toggle_button', require('./../components/ToggleButtonComponent'));
Vue.component('input_component', require('./../components/InputComponent.vue'));
import modal from './../components/ModalComponent.vue';
import helper from '../mixins/helper';

Vue.filter('caseInsensitiveOrderBy', function (arr, sortKey, reverse) {
    // arr = convertArray(arr)
    if (!sortKey) {
        return arr
    }
    var order = (reverse && reverse < 0) ? -1 : 1
    // sort on a copy to avoid mutating original array
    return arr.slice().sort(function (a, b) {
        if (sortKey !== '$key') {
            if (Vue.util.isObject(a) && '$value' in a) a = a.$value
            if (Vue.util.isObject(b) && '$value' in b) b = b.$value
        }
        a = Vue.util.isObject(a) ? Vue.parsers.path.getPath(a, sortKey) : a
        b = Vue.util.isObject(b) ? Vue.parsers.path.getPath(b, sortKey) : b

        a = a.toLowerCase()
        b = b.toLowerCase()

        return a === b ? 0 : a > b ? order : -order
    })
});

const app = new Vue({
    el: '#app',
    components: {
        modal,
    },
    mixins: [helper],
    mounted() {
        console.log('app mounted')
    },
    methods: {},
});





