import Vue from 'vue';
import Vuex from 'vuex';
import fontApi from "../services/api/fonts";
import colorApi from "../services/api/colors";
import colorsApi from '../services/api/colors.js';
import LogoSampleIcon from '../components/logo_samples/Icon.vue';
import LogoSampleInitials from '../components/logo_samples/Initials.vue';
import LogoSampleTypo from '../components/logo_samples/Typography.vue';
import lsHelper from '../helpers/localStorageHelper.js';
// import plugins from './plugins';

Vue.use(Vuex);

const state = {
  width: 1024,
  height: 768,

  // -- logo model start --
  id: 0,
  backgroundColor: {
    hex: '',
    rgba: {},
    a: 1
  },
  layout: 'vertical-icon',
  scale: 1.0,
  // -- logo model end --

  loading: false,

  isAuthenticated: !!document.head.querySelector('meta[name="api-token"]'),

  // -- editor start --
  fontCategories: {},
  paletteCategories: {},
  paletteOptions: [],
  colorCategories: [],
  // -- editor end --

  // -- editor, recommendations, conversations start --
  companyDetails: '',
  companyNameText: '', // exception: due to duplicated name in module
  sloganText: '', // exception: due to duplicated name in module
  kinds: [
    { id: 1, component: LogoSampleIcon, name: 'Icon Logo', layout: 'icon', speech: 'I\'ll design a Picture-Based Logo for you.', selected: false },
    { id: 2, component: LogoSampleInitials, name: 'Initials Logo', layout: 'initial', speech: 'I\'ll design a Logo with Initials for you.', selected: false },
    { id: 3, component: LogoSampleTypo, name: 'Typography Logo', layout: 'typography', speech: 'I\'ll design a Typography based logo for you.', selected: false },
  ],
  // -- editor, recommendations, conversations end --
};

const getters = {
  palette (state) {
    for (let category in state.paletteCategories) {
      if (state.paletteCategories.hasOwnProperty(category) && state.paletteCategories[category].selected) {
        return state.paletteCategories[category];
      }
    }
  },

  tickedPaletteCategoriesIds () {
    let ids = [];

    for (let category in state.paletteCategories) {
      if (state.paletteCategories.hasOwnProperty(category) && state.paletteCategories[category].ticked) {
        ids.push(state.paletteCategories[category].id);
      }
    }

    return ids;
  },

  backgroundColor () {
    return state.backgroundColor.hex;
  },

  companyNameText () {
    return state.companyNameText;
  },

  sloganText () {
    return state.sloganText;
  },

  companyDetails () {
    return state.companyDetails;
  },

  selectedLayouts (state) {
    return state.kinds
      .filter(kind => kind.selected)
      .map(kind => kind.layout);
  },

  selectedColorCategoriesIds (state) {
    return state.colorCategories
      .filter(category => category.checked)
      .map(category => category.id);
  },

  kinds (state) {
    return state.kinds;
  },

  loading (state, getters) {
    return state.loading ||
      getters['companyName/loading'] ||
      getters['slogan/loading'] ||
      getters['symbol/loading'] ||
      getters['container/loading'] ||
      getters['product/loading'] ||
      getters['payment/loading'] ||
      getters['recommendation/loading'];
  },

  logoSettings (state, getters) {
    return JSON.parse(
      JSON.stringify(
        {
          settings: {
            width: state.width,
            height: state.height,

            id: state.id,
            backgroundColor: state.backgroundColor,
            layout: state.layout,
            scale: state.scale,
          },
          companyNameSettings: getters['companyName/settings'],
          sloganSettings: getters['slogan/settings'],
          symbolSettings: getters['symbol/settings'],
          containerSettings: getters['container/settings'],
        }
      )
    );
  },

  isAuthenticated(state) {
    return state.isAuthenticated;
  }
};

const mutations = {
  UPDATE_COMPANY_NAME_TEXT (state, payload) {
    state.companyNameText = payload;
  },

  UPDATE_SLOGAN_TEXT (state, payload) {
    state.sloganText = payload;
  },

  UPDATE_COMPANY_DETAILS (state, payload) {
    state.companyDetails = payload;
  },

  UPDATE_KIND (state, payload) {
    state.kind = payload;
  },

  UPDATE_CHECKED_COLOR_CATEGORY (state, payload) {
    state.colorCategories.forEach(function(category) {
      if (category.name === payload.name) {
        category.checked = payload.checked;
      }
    });

    state.colorCategories = state.colorCategories.slice();
  },

  UPDATE_COLOR_CATEGORIES (state, payload) {
    state.colorCategories = payload;
  },

  UPDATE_CHECKED_COLOR_CATEGORY_BY_ID (state, payload) {
    state.colorCategories.forEach(function(category) {
      if (category.id === payload) {
        category.checked = true;
      }
    });
  },

  UPDATE_SELECTED_KIND (state, payload) {
    state.kinds.forEach(function(kind) {
      if (kind.name === payload.name) {
        kind.selected = payload.selected;
      }
    });

    state.kinds = state.kinds.slice();
  },

  UPDATE_SELECTED_KIND_BY_LAYOUT (state, payload) {
    state.kinds.forEach(function(kind) {
      if (kind.layout === payload) {
        kind.selected = true;
      }
    });
  },

  UPDATE_FONT_LIST (state, payload) {
    state.fontCategories = payload;
  },

  UPDATE_PALETTE_CATEGORIES (state, payload) {
    state.paletteCategories = payload;
  },

  UPDATE_PALETTE_OPTIONS (state, payload) {
    state.paletteOptions = payload;
  },

  UPDATE_TICKED_PALETTE (state, payload) {
    for (let category in state.paletteCategories) {
      if (state.paletteCategories.hasOwnProperty(category)) {
        if (state.paletteCategories[category].id === payload.id) {
          state.paletteCategories[category].ticked = !state.paletteCategories[category].ticked;
        }
      }
    }
    state.paletteCategories = Object.assign({}, state.paletteCategories);
  },

  UPDATE_SELECTED_PALETTE (state, payload) {
    for (let category in state.paletteCategories) {
      if (state.paletteCategories.hasOwnProperty(category)) {
        state.paletteCategories[category].selected = (state.paletteCategories[category].id === payload.id);
      }
    }
    state.paletteCategories = Object.assign({}, state.paletteCategories);
  },

  UPDATE_BACKGROUND_COLOR (state, payload) {
    state.backgroundColor = payload;
  },

  UPDATE_ID (state, payload) {
    state.id = payload;
  },

  UPDATE_WIDTH (state, payload) {
    state.width = payload;
  },

  UPDATE_HEIGHT (state, payload) {
    state.height = payload;
  },

  UPDATE_LAYOUT (state, payload) {
    state.layout = payload;
  },

  UPDATE_SCALE (state, payload) {
    state.scale = payload;
  },

  UPDATE_LOADING (state, payload) {
    state.loading = payload;
  },
};

export const actions = {
  updateCompanyNameText ({ commit }, payload) {
    commit('UPDATE_COMPANY_NAME_TEXT', payload);
  },

  updateCompanyDetails ({ commit }, payload) {
    commit('UPDATE_COMPANY_DETAILS', payload);
  },

  updateSloganText ({ commit }, payload) {
    commit('UPDATE_SLOGAN_TEXT', payload);
  },

  initFont ({ state, commit, dispatch }) {
    fontApi.getList({}, (data) => {
      if (data.status === 'success') {
        let fontList = data.payload.categories;

        commit('UPDATE_FONT_LIST', fontList);

        let categories = Object.keys(fontList);

        dispatch('companyName/initFont', fontList[categories[0]][0]);
        dispatch('slogan/initFont', fontList[categories[0]][0]);
        dispatch('symbol/initFont', fontList[categories[0]][0]);
      }
    });
  },

  initPalette ({commit, dispatch}) {
    colorApi.getList({}, (data) => {
      if (data.status === 'success') {
        let paletteCategories = data.payload.categories;

        for (let category in paletteCategories) {
          paletteCategories[category].ticked = false;
        }

        commit('UPDATE_PALETTE_CATEGORIES', paletteCategories);

        let categories = Object.keys(paletteCategories);

        dispatch('updatePalette', paletteCategories[categories[0]]);
      }
    });
  },

  updatePalette ({commit}, payload) {
    colorApi.getPalette({
      toneId: payload.id
    }, (data) => {
      if (data.status === 'success') {
        let paletteOptions = data.payload.options;

        commit('UPDATE_SELECTED_PALETTE', payload);
        commit('UPDATE_PALETTE_OPTIONS', paletteOptions);
      }
    });
  },

  updateTickedPalette ({commit}, payload) {
    commit('UPDATE_TICKED_PALETTE', payload);
  },

  applyPalette ({dispatch}, payload) {
    let rgb = Vue.hexToRgb(payload.company_name_color);
    dispatch('companyName/updateColor', {
      hex: payload.company_name_color,
      rgba: { r: rgb.r, g: rgb.g, b: rgb.b, a: 1 }
    });

    rgb = Vue.hexToRgb(payload.slogan_color);
    dispatch('slogan/updateColor', {
      hex: payload.slogan_color,
      rgba: { r: rgb.r, g: rgb.g, b: rgb.b, a: 1 }
    });

    rgb = Vue.hexToRgb(payload.symbol_color);
    dispatch('symbol/updateColor', {
      hex: payload.symbol_color,
      rgba: { r: rgb.r, g: rgb.g, b: rgb.b, a: 1 }
    });

    rgb = Vue.hexToRgb(payload.bg_color);
    dispatch('updateBackgroundColor', {
      hex: payload.bg_color,
      rgba: rgb ? { r: rgb.r, g: rgb.g, b: rgb.b, a: 1 } : null
    });
  },

  updateCheckedColorCategory ({ commit }, payload) {
    commit('UPDATE_CHECKED_COLOR_CATEGORY', payload);
  },

  updateSelectedKind ({ commit }, payload) {
    commit('UPDATE_SELECTED_KIND', payload);
  },

  updateSelectedKindByLayout ({ commit }, payload) {
    commit('UPDATE_SELECTED_KIND_BY_LAYOUT', payload);
  },

  getColorCategories ({ commit }) {
    colorsApi.getColorCategories({}, (response) => {
      if (response.status === 'success') {
        commit('UPDATE_COLOR_CATEGORIES', response.payload);
      }
    });
  },

  updateBackgroundColor ({commit}, payload) {
    commit('UPDATE_BACKGROUND_COLOR', payload);
  },

  updateId ({ commit }, payload) {
    commit('UPDATE_ID', payload);
  },

  updateScale ({ commit }, payload) {
    commit('UPDATE_SCALE', payload);
  },

  updateIds ({ commit, dispatch }, payload) {
    return Promise.all([
      dispatch('updateId', payload.id || 0),
      dispatch('companyName/updateId', payload.name_id || 0),
      dispatch('slogan/updateId', payload.slogan_id || 0),
      dispatch('symbol/updateIconId', payload.icon_id || 0),
      dispatch('symbol/updateInitialsId', payload.initials_id || 0),
      dispatch('container/updateId', payload.logo_container_id || 0),
    ]);
  },

  updateLayout ({ commit }, payload) {
    commit('UPDATE_LAYOUT', payload);
  },

  updateLoading ({ commit }, payload) {
    commit('UPDATE_LOADING', payload);
  },

  cloneSettings ({ dispatch }, payload) {
    return Promise.all([
      dispatch('cloneLogoSettings', payload.settings),
      dispatch('companyName/cloneSettings', payload.companyNameSettings),
      dispatch('slogan/cloneSettings', payload.sloganSettings),
      dispatch('symbol/cloneSettings', payload.symbolSettings),
      dispatch('container/cloneSettings', payload.containerSettings),
    ]);
  },

  cloneLogoSettings ({ commit }, payload) {
    return new Promise(function(resolve, reject) {
      commit('UPDATE_WIDTH', payload.width);
      commit('UPDATE_HEIGHT', payload.height);

      commit('UPDATE_ID', payload.id);
      commit('UPDATE_BACKGROUND_COLOR', payload.backgroundColor);
      commit('UPDATE_LAYOUT', payload.layout);
      commit('UPDATE_SCALE', payload.scale);

      resolve();
    });
  },

  retrieveLogoInfo ({ commit, getters, dispatch }) {
    return new Promise((resolve, reject) => {
      let logoInfo = lsHelper.get('logoInfo');

      dispatch('updateCompanyNameText', logoInfo.companyName);
      dispatch('updateCompanyDetails', logoInfo.companyDetails);
      dispatch('updateSloganText', logoInfo.slogan);
      if (Array.isArray(logoInfo.layout)) {
        logoInfo.layout.forEach((layout) => {
          dispatch('updateSelectedKindByLayout', layout);
        });
      }
      colorsApi.getColorCategories({})
        .then((response) => {
          if (response.status === 'success') {
            commit('UPDATE_COLOR_CATEGORIES', response.payload, { root: true });

            if (Array.isArray(logoInfo.colorCategoriesIds)) {
              logoInfo.colorCategoriesIds.forEach((id) => {
                commit('UPDATE_CHECKED_COLOR_CATEGORY_BY_ID', id);
              });
            }
          }

          resolve();
        }).catch((error) => {
        reject(error);
      });
    });
  },

  storeLogoInfo ({ getters }) {
    lsHelper.set('logoInfo', {
      companyName: getters.companyNameText,
      companyDetails: getters.companyDetails,
      slogan: getters.sloganText,
      layout: getters.selectedLayouts,
      colorCategoriesIds: getters.selectedColorCategoriesIds,
    });
  }
};

// Load store modules dynamically.
const requireContext = require.context('./modules', false, /.*\.js$/);

const modules = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
  )
  .reduce((modules, [name, module]) => {
    if (module.namespaced === undefined) {
      module.namespaced = true
    }

    return { ...modules, [name]: module }
  }, {});

export default new Vuex.Store({
  state,
  getters,
  actions,
  mutations,
  modules,
  // plugins
})