const Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('start-modal', require('./components/pricing/StartModal.vue').default);

import lsHelper from './helpers/localStorageHelper.js';
import Helpers from './plugins/Helpers';

Vue.use(Helpers);

const pricingApp = new Vue({
    el: '#pricing-app',
    store: require('./store').default,
    data() {
        return {
            activeTab: 'premium',
            showStartModal: false,
            downloadSettings: lsHelper.get('downloadSettings') || {},
        }
    },
    computed: {
        isDesktop() {
            return Vue.isDesktop();
        }
    },
    methods: {
        updateShowStartModal(value) {
            this.showStartModal = value;
        },
        selectPackage(name) {
            lsHelper.remove('downloadSettings');
            lsHelper.set('downloadSettings', {
                packageName: name,
            });
            this.updateShowStartModal(true);
        },
    },
});