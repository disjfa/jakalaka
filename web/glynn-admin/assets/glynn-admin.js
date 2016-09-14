var jQuery = require('jquery');
window.$ = window.jQuery = jQuery;

var Tether = require('tether');
window.Tether = Tether;

var Vue = require('vue');
var VueResource = require('vue-resource');

Vue.use(VueResource);
Vue.config.delimiters = ['${', '}'];

require('bootstrap');
require('chart.js');
require('../../bundles/disjfabuilder/js/builder.js');

new Vue({
    el: '#base'
});