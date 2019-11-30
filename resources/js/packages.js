
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

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

const Vue = require('vue');

Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('errorMessageModal', require('./components/ErrorMessageModal.vue').default);

import Helpers from './plugins/Helpers';
Vue.use(Helpers);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import packagesApi from "./services/api/packages.js";
import lsHelper from './helpers/localStorageHelper.js';
import BackLinkMixin from './mixins/BackLink.js';

const app = new Vue({
  el: '#app',
  store: require('./store').default,
  mixins: [BackLinkMixin],
  data() {
    return {
      jpgLink: null,
      downloadSettings: lsHelper.get('downloadSettings'),
      showErrorMessageModal: false,
      errorMessage: 'Something went wrong, please contact to admin to download the logo.'
    }
  },
  created() {
    this.storeHistoryData();
  },
  computed: {
    isDesktop() {
      return Vue.isDesktop();
    }
  },
  // todo: update flows - price -> logo -> order, logo -> package -> order, both should work flexible : think about finite state diagram of download settings
  methods: {
    goToEditorPage() {
      window.location.href = window.location.origin + '/editor';
    },
    goToCheckoutPage() {
      window.location.href = window.location.origin + '/checkout';
    },
    createFreeLogo(logoId) {
      return this.$store.dispatch('product/createFreeLogo', { logoId })
        .then(res => {
          if (res.status === 'success') {
            if (res.payload.jpgLink) {
              this.jpgLink = res.payload.jpgLink;
              this.downloadLink = res.payload.downloadLink;
            } else if (res.payload.message) {
              this.showErrorMessage(res.payload.message);
            }
          }
        })
        .catch((err) => {
          this.showErrorMessage(err);
        });
    },
    downloadFreeLogo() {
      if (this.downloadLink) {
        window.location.href = this.downloadLink;
      }
    },
    moveToNextStep() {
      if (this.downloadSettings.price) {
        lsHelper.set('downloadSettings', this.downloadSettings);

        this.goToCheckoutPage();
      } else {
        this.downloadFreeLogo();
      }
    },
    selectPackage(name) {
      if (this.downloadSettings && this.downloadSettings.logoId) {
        packagesApi.get({ name })
          .then(res => {
            if (res.status === 'success') {
              if (Array.isArray(res.payload) && res.payload.length === 1) {
                this.downloadSettings.price = res.payload[0].price;
                this.downloadSettings.packageName = name;
                this.downloadSettings.packageId = res.payload[0].id;

                this.moveToNextStep();
              }
            }
          });
      } else {
        this.goToEditorPage();
      }
    },
    showErrorMessage(message) {
      this.errorMessage = message;
      this.updateShowErrorMessageModal(true);
    },
    updateShowErrorMessageModal(show) {
      this.showErrorMessageModal = show;
    }
  },
  mounted() {
    if (this.downloadSettings && this.downloadSettings.logoId) {
      this.createFreeLogo(this.downloadSettings.logoId);
    }
  }
});
