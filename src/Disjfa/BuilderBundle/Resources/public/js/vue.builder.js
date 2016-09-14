var Vue = require('vue');

Vue.component('builder', {
    props: ['builderId'],
    template: '<span>${ builderId }</span>',
    ready: function() {
        console.log(this.builderId);
    }
});

