var jQuery = require('jquery');
window.$ = window.jQuery = jQuery;

window.$.ui = require('jquery-ui');
require('jquery-ui/ui/data');
require('jquery-ui/ui/plugin');
require('jquery-ui/ui/safe-active-element');
require('jquery-ui/ui/safe-blur');
require('jquery-ui/ui/scroll-parent');
require('jquery-ui/ui/version');
require('jquery-ui/ui/disable-selection');
require('jquery-ui/ui/widgets/mouse');
require('jquery-ui/ui/widgets/draggable');
require('jquery-ui/ui/widgets/resizable');

var Tether = require('tether');
window.Tether = Tether;

var Vue = require('vue');
var VueResource = require('vue-resource');

Vue.use(VueResource);

require('bootstrap');
require('chart.js');

new Vue({
    el: '#base',
    components: {
        'picture': require('../../bundles/disjfapicture/js/picture.vue'),
        'builder': require('../../bundles/disjfabuilder/js/builder.vue')
    }
});