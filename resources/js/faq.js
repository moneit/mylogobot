const Vue = require('vue');

Vue.component('faq', require('./components/FAQ.vue').default);

const faqApp = new Vue({
    el: '#faq-app',
});