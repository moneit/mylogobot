
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('loader', require('./components/Loader.vue').default);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('error-message-modal', require('./components/ErrorMessageModal.vue').default);

const app = new Vue({
    el: '#app',
    store: require('./store').default,
    data() {
        return {
            showErrorMessageModal: false,
            errorMessage: '',
        }
    },
    methods: {
        download(orderId) {
            this.$store.dispatch('product/downloadFromOrder', { orderId })
                .then((res) => {
                    if (res.status === 'success') {
                        if (res.payload.downloadLink) {
                            window.location.href = res.payload.downloadLink;
                        } else if (res.payload.message) {
                            this.showErrorMessage(res.payload.message);
                        }
                    } else {
                        this.showErrorMessage(res.payload.message);
                    }
                });
        },
        showErrorMessage(message) {
            this.errorMessage = message;
            this.updateShowErrorMessageModal(true);
        },
        updateShowErrorMessageModal(value) {
            this.showErrorMessageModal = value;
        },
    }
});
