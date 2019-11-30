
// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// try {
//     window.Popper = require('popper.js').default;
//     window.$ = window.jQuery = require('jquery');
//
//     require('bootstrap');
// } catch (e) {}

const Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import {CONVERSATION_PAGE} from "./services/routing/pages";
import router from "./services/routing/router";

const footerApp = new Vue({
    el: '#footer-app',
    store: require('./store/footer').default,
    data() {
        return {
            companyName: '',
        }
    },
    methods: {
        startConversation() {
            if (this.companyName) {
                this.$store.dispatch('updateCompanyName', this.companyName);
                this.$store.dispatch('storeLogoInfo');
                router.goToPage(CONVERSATION_PAGE);
            }
        }
    }
});
