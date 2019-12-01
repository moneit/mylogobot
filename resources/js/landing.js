
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

Vue.component('form-input', require('./components/FormInput.vue').default);
Vue.component('carousel', require('./components/Carousel.vue').default);
Vue.component('good-logos-modal', require('./components/GoodLogosModal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { CONVERSATION_PAGE } from './services/routing/pages.js';
import router from './services/routing/router.js';

const app = new Vue({
  el: '#landing-app',
  store: require('./store/landing').default,
  data() {
    return {
      companyName: '',
      inputClass: '',
      testimonials: [
        {description: '“I was looking for a professional logo design, but then I found out that Logo.bot could get me a logo with their AI. I didn’t buy this idea immediately, but within 5 minutes, I had my brand ready for my product”', author: "Xavier, Amazing Safari"},
        {description: '“We have spent 500$ with a designer who didn’t deliver anything after 4 weeks. Then we discovered Logo.Bot and our logos were done in few minutes for a fraction of the price. The next day I’ve printed my business cards and my business was running. If you need a cheap logo with top quality, that’s Logo.Bot.”', author: "Sara, Star Expeditions"},
        {description: '“I was looking for a professional logo design, but then I found out that Logo.bot could get me a logo with their AI. I didn’t buy this idea immediately, but within 5 minutes, I had my brand ready for my product”', author: "Xavier, Amazing Safari"},
        {description: '“We have spent 500$ with a designer who didn’t deliver anything after 4 weeks. Then we discovered Logo.Bot and our logos were done in few minutes for a fraction of the price. The next day I’ve printed my business cards and my business was running. If you need a cheap logo with top quality, that’s Logo.Bot.”', author: "Sara, Star Expeditions"},
        {description: '“I was looking for a professional logo design, but then I found out that Logo.bot could get me a logo with their AI. I didn’t buy this idea immediately, but within 5 minutes, I had my brand ready for my product”', author: "Xavier, Amazing Safari"},
        {description: '“We have spent 500$ with a designer who didn’t deliver anything after 4 weeks. Then we discovered Logo.Bot and our logos were done in few minutes for a fraction of the price. The next day I’ve printed my business cards and my business was running. If you need a cheap logo with top quality, that’s Logo.Bot.”', author: "Sara, Star Expeditions"},
        {description: '“I was looking for a professional logo design, but then I found out that Logo.bot could get me a logo with their AI. I didn’t buy this idea immediately, but within 5 minutes, I had my brand ready for my product”', author: "Xavier, Amazing Safari"},
        {description: '“We have spent 500$ with a designer who didn’t deliver anything after 4 weeks. Then we discovered Logo.Bot and our logos were done in few minutes for a fraction of the price. The next day I’ve printed my business cards and my business was running. If you need a cheap logo with top quality, that’s Logo.Bot.”', author: "Sara, Star Expeditions"},
        {description: '“I was looking for a professional logo design, but then I found out that Logo.bot could get me a logo with their AI. I didn’t buy this idea immediately, but within 5 minutes, I had my brand ready for my product”', author: "Xavier, Amazing Safari"},
        {description: '“We have spent 500$ with a designer who didn’t deliver anything after 4 weeks. Then we discovered Logo.Bot and our logos were done in few minutes for a fraction of the price. The next day I’ve printed my business cards and my business was running. If you need a cheap logo with top quality, that’s Logo.Bot.”', author: "Sara, Star Expeditions"},
      ],
      goodLogoPaths: [
        '/img/landing/checkmate.svg',
        '/img/landing/sportsmart.svg',
        '/img/landing/hurricanes.svg',
        '/img/landing/naturay.svg',
        '/img/landing/south_bay.svg',
        '/img/landing/mr.noce.svg',
        '/img/landing/tagus_tour.svg',
        '/img/landing/pet_spa.svg',
      ],
      showGoodLogoModal: false,
      selectedLogoPath: '',
    }
  },
  mounted() {
    this.$refs.input.addEventListener('focus', (e) => {
      this.inputClass = 'green';
    });
    this.$refs.input.addEventListener('blur', (e) => {
      this.inputClass = '';
    });
  },
  methods: {
    startConversation() {
      if (this.companyName) {
        this.$store.dispatch('updateCompanyNameText', this.companyName);
        this.$store.dispatch('storeLogoInfo');
        router.goToPage(CONVERSATION_PAGE);
      } else {
        this.$refs.input.focus();
        this.$nextTick(() => {
          this.inputClass = 'red';
        });
      }
    },
    openGoodLogoModal(path) {
      this.showGoodLogoModal = true;
      this.selectedLogoPath = path;
    },
    updateShowGoodLogoModal(value) {
      this.showGoodLogoModal = value;
    }
  }
});
