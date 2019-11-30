/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

Vue.component('logo', require('./components/logo/Logo.vue').default);
Vue.component('logo-symbol', require('./components/logo-symbol/LogoSymbol.vue').default);
Vue.component('logo-input', require('./components/LogoInput.vue').default);
Vue.component('slider', require('./components/editor/Slider.vue').default);
Vue.component('text-capitalizer', require('./components/editor/TextCapitalizer.vue').default);
Vue.component('text-capitalizer-mobile', require('./components/editor/TextCapitalizerMobile.vue').default);
Vue.component('font-selector', require('./components/editor/FontSelector.vue').default);
Vue.component('font-selector-mobile', require('./components/editor/FontSelectorMobile.vue').default);
Vue.component('color-selector', require('./components/editor/ColorSelector.vue').default);
Vue.component('icon-selector', require('./components/editor/IconSelector.vue').default);
Vue.component('remove-icon-switch', require('./components/editor/RemoveIconSwitch.vue').default);
Vue.component('type-selector', require('./components/editor/TypeSelector.vue').default);
Vue.component('palette-selector', require('./components/editor/PaletteSelector.vue').default);
Vue.component('container-selector', require('./components/editor/ContainerSelector.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('logo-preview-wrapper', require('./components/logo/LogoPreviewWrapper.vue').default);
Vue.component('logo-save-success-modal', require('./components/editor/StoreSuccessModal.vue').default);
Vue.component('color-combination-save-modal', require('./components/editor/ColorCombinationSaveModal.vue').default);
Vue.component('font-combination-save-modal', require('./components/editor/FontCombinationSaveModal.vue').default);
Vue.component('error-message-modal', require('./components/ErrorMessageModal.vue').default);
Vue.component('success-message-modal', require('./components/SuccessMessageModal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import logoApi from "./services/api/logo";
import lsHelper from './helpers/localStorageHelper.js';
import BackLinkMixin from './mixins/BackLink.js';

const app = new Vue({
  el: '#app',
  store: require('./store').default,
  mixins: [BackLinkMixin],
  created() {
    const historyData = this.getHistoryData();

    if (historyData) {
      this.$store.dispatch('cloneSettings', historyData);
    } else {
      let storedLogoSettings = lsHelper.get('logoSettings');
      if (storedLogoSettings && storedLogoSettings.settings) {
        this.$store.dispatch('cloneSettings', storedLogoSettings);
        this.storeHistoryData(storedLogoSettings);
        lsHelper.remove('logoSettings');
      } else {
        let downloadSettings = lsHelper.get('downloadSettings');

        if (downloadSettings && downloadSettings.logoId) {
          logoApi.getSettings({
            logoId: downloadSettings.logoId
          })
            .then(res => {
              if (res.status === 'success') {
                this.renderPreview(res.payload);
              }
            });
        }
      }
    }

    this.$store.dispatch('initFont');
    this.$store.dispatch('initPalette');
    this.$store.dispatch('container/initContainers');
  },
  data() {
    return {
      previewSettings: {
        settings: {},
        containerSettings: {},
        companyNameSettings: {},
        sloganSettings: {},
        symbolSettings: {},
      },
      showStoreSuccessModal: false,
      downloadInProgress: false,
      showColorCombinationModal: false,
      showFontCombinationModal: false,
      showErrorMessageModal: false,
      errorMessage: '',
      showSuccessMessageModal: false,
      successMessage: '',
      previewRendering: false,
    }
  },

  methods: {
    store() {
      return new Promise((resolve, reject) => {

        let symbolOnlySvg = document.getElementById('logo-symbol-only').innerHTML;
        symbolOnlySvg = symbolOnlySvg.split(' ').filter(function(snippet) {
          return !snippet.includes('data-v-');
        }).join(' ');

        let svg = document.getElementById('logo-editor').innerHTML;
        svg = svg.split(' ').filter(function(snippet) {
          return !snippet.includes('data-v-');
        }).join(' ');

        let state = this.$store.state;
        let params = {
          symbol_only_svg: symbolOnlySvg,
          svg: svg,
          id: state.id,
          bg_color: state.backgroundColor.hex,
          layout: state.layout,
          scale: state.scale,
        };
        params.name = {
          id: state.companyName.id,
          font_id: state.companyName.font.id,
          text: state.companyName.text,
          font_size: state.companyName.fontSize,
          letter_space: state.companyName.letterSpace,
          line_space: state.companyName.lineSpace,
          color_hex: state.companyName.color.hex,
          color_opacity: state.companyName.color.rgba.a,
          capitalization: state.companyName.capitalization,
        };
        params.slogan = {
          id: state.slogan.id,
          font_id: state.slogan.font.id,
          text: state.slogan.text,
          font_size: state.slogan.fontSize,
          letter_space: state.slogan.letterSpace,
          line_space: state.slogan.lineSpace,
          color_hex: state.slogan.color.hex,
          color_opacity: state.slogan.color.rgba.a,
          capitalization: state.slogan.capitalization,
        };
        params.icon = {
          id: state.symbol.iconId,
          tags: state.symbol.tags,
          bounds: state.symbol.iconBounds,
          clip_rule: state.symbol.iconClipRule,
          fill_rule: state.symbol.iconFillRule,
          size: state.symbol.iconSize,
          line_space: state.symbol.lineSpace,
          color_hex: state.symbol.color.hex,
          color_opacity: state.symbol.color.rgba.a,
          hidden: state.symbol.iconHidden,
        };
        params.initials = {
          id: state.symbol.initialsId,
          font_id: state.symbol.font.id,
          text: state.symbol.text,
          font_size: state.symbol.fontSize,
          letter_space: state.symbol.letterSpace,
          line_space: state.symbol.lineSpace,
          color_hex: state.symbol.color.hex,
          color_opacity: state.symbol.color.rgba.a,
        };
        params.container = {
          id: state.container.id,
          container_id: state.container.selected.id,
          size: state.container.size,
          color_hex: state.container.color.hex,
          color_opacity: state.container.color.rgba.a,
        };

        logoApi.save(params, (res) => {
          if (res.status === 'success') {
            this.$store.dispatch('updateIds', res.payload.result).then(() => {
              this.storeHistoryData(this.$store.getters.logoSettings);
              resolve(res);
            });
          } else {
            reject();
          }
        }, (err) => {
          console.log('err', err);
          reject(err);
        });
      })
    },
    save() {
      this.store()
        .then(() => {
          this.showStoreSuccessModal = true;
        });
    },
    goToPackagesPage() {
      lsHelper.set('downloadSettings', {
        'logoId': this.$store.state.id
      });

      this.storeHistoryData(this.$store.getters.logoSettings);

      window.location.href = window.location.origin + '/packages';
    },
    storeGoPackagesPage() {
      this.store()
        .then(() => {
          this.goToPackagesPage();
        });
    },
    download() {
      this.storeGoPackagesPage();
    },
    updateShowStoreSuccessModal(value) {
      this.showStoreSuccessModal = value;
    },
    updateShowColorCombinationModal(value) {
      this.showColorCombinationModal = value;
    },
    updateShowFontCombinationModal(value) {
      this.showFontCombinationModal = value;
    },
    openColorCombinationModal() {
      this.updateShowColorCombinationModal(true);
    },
    openFontCombinationModal() {
      this.updateShowFontCombinationModal(true);
    },
    updateShowErrorMessageModal(value) {
      this.showErrorMessageModal = value;
    },
    updateShowSuccessMessageModal(value) {
      this.showSuccessMessageModal = value;
    },
    showErrorMessage(message) {
      this.errorMessage = message;
      this.updateShowErrorMessageModal(true);
    },
    showSuccessMessage(message) {
      this.successMessage = message;
      this.updateShowSuccessMessageModal(true);
    },
    renderPreview() {
      this.previewRendering = true;
    },
  },
  watch: {
    '$store.state': {
      deep: true,
      handler: _.debounce(function(state) {
        const logoSettings = this.$store.getters.logoSettings;

        this.previewSettings = {
          settings: logoSettings.settings,
          containerSettings: logoSettings.containerSettings,
          symbolSettings: logoSettings.symbolSettings,
          companyNameSettings: logoSettings.companyNameSettings,
          sloganSettings: logoSettings.sloganSettings,
        }
      }, 1000)
    }
  }
});

/**
 * Scroll management
 */
$(document).ready(function () {

  var mobileTopNav = $('#mobile-top');
  var mobileTopFixedNav = $('#mobile-top-fixed');
  var offset = mobileTopNav.height() - mobileTopFixedNav.height();

  function scroll() {
    if ($(window).scrollTop() >= offset) {
      mobileTopFixedNav.css('visibility', 'visible');
    } else {
      mobileTopFixedNav.css('visibility', 'hidden');
    }
  }

  document.onscroll = scroll;

});