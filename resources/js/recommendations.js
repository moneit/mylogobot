
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

window.Vue = require('vue');

import Helpers from './plugins/Helpers';
Vue.use(Helpers);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('recommendations', require('./components/recommendations/Recommendations.vue').default);
Vue.component('recommendations-mobile', require('./components/recommendations/RecommendationsMobile.vue').default);
Vue.component('recommendations-failure-modal', require('./components/recommendations/RecommendationsFailureModal.vue').default);
Vue.component('form-input', require('./components/FormInput.vue').default);
Vue.component('country-selector', require('./components/CountrySelector.vue').default);
Vue.component('bot-loader', require('./components/BotLoader.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('transparent-signup-modal-overlay', require('./components/recommendations/TransparentSignupModalOverlay.vue').default);
Vue.component('logo-preview-wrapper', require('./components/logo/LogoPreviewWrapper.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import BackLinkMixin from './mixins/BackLink.js';

const app = new Vue({
  el: '#app',
  store: require('./store').default,
  mixins: [BackLinkMixin],
  data() {
    const historyData = this.getHistoryData();
    const isAuthenticated = this.$store.getters.isAuthenticated;

    return {
      previewSettings: {
        settings: {},
        containerSettings: {},
        companyNameSettings: {},
        sloganSettings: {},
        symbolSettings: {},
      },
      renderingCompleted: false,
      refreshPreview: false,
      showTransparentSignupForm: !isAuthenticated,
      showLogos: true,
      historyData
    }
  },
  mounted() {
    if (this.showTransparentSignupForm) {
      this.makeBackgroundBlurred();
    }
  },
  created() {
    this.$store.dispatch('retrieveLogoInfo')
      .then(() => {
        if (this.historyData) {
          this.$store.dispatch('recommendation/setLogoRecommendations', this.historyData);
        } else {
          this.$store.dispatch('recommendation/generateLogos');
        }
      });
  },
  methods: {
    setPreviewSettings(settings) {
      this.previewSettings = settings;
      this.refreshPreview = true;
      this.$nextTick(() => {
        this.refreshPreview = false;
      });
    },
    updateShowTransparentSignupForm(value) {
      this.showTransparentSignupForm = value;
    },
    makeBackgroundBlurred() {
      let blurables = Array.prototype.slice.call(document.getElementsByClassName('blurable'));

      blurables.forEach(blurable => {
        blurable.style = "filter: blur(5px)";
      });
    },
    updateShowRecommendationsFailureModal(value) {
      if (value) {
        this.showRecommendationsFailureModal = value;
      } else {
        this.goToHomePage();
      }
    },
    goToHomePage() {
      window.location.href = window.location.origin;
    },
  },
  computed: {
    isMobile() {
      return window.Vue.isMobile();
    },
    isAuthenticated() {
      return this.$store.getters.isAuthenticated;
    },
    recommendationsLoading() {
      return this.$store.getters['recommendation/loading'];
    },
    recommendationsErrorMessage() {
      return this.$store.getters['recommendation/errorMessage'];
    },
    showRecommendationsFailureModal: {
      get() {
        return !!this.recommendationsErrorMessage;
      },
      set(value) {
        if (!value) {
          this.$store.dispatch('recommendation/removeErrorMessage');
          this.$store.dispatch('recommendation/generateLogos');
        }
      }
    },
  },
  watch: {
  }
});
