import recommendationApi from "../../services/api/recommendations.js";

const recommendedLogosFetchCount = 6;

export const state = {
  logoRecommendations: [],
  loading: false,
  errorMessage: '',
};

export const getters = {
  loading (state) {
    return state.loading;
  },

  count(state) {
    return state.logoRecommendations.length;
  },

  errorMessage (state) {
    return state.errorMessage;
  },

  logoRecommendations (state) {
    return state.logoRecommendations;
  }
};

export const mutations = {
  PUSH_LOGO_RECOMMENDATIONS (state, payload) {
    payload.forEach(function(logo, idx) { // push one by one not to send chunk requests to server
      setTimeout(function() {
        logo.ts = + new Date();
        state.logoRecommendations.splice(state.logoRecommendations.length - 6 + idx, 1, logo);
      }, 500 * idx);
    });
  },

  SET_LOGO_RECOMMENDATIONS (state, payload) {
    state.logoRecommendations = payload.slice();
  },

  UPDATE_LOADING (state, payload) {
    state.loading = payload;
  },

  SET_ERROR_MESSAGE (state, payload) {
    state.errorMessage = payload;
  },
};

export const actions = {
  pushLogoRecommendations ({ commit }, payload) {
    commit('PUSH_LOGO_RECOMMENDATIONS', payload);
  },

  setLogoRecommendations({ commit }, payload) {
    commit('SET_LOGO_RECOMMENDATIONS', payload);
  },

  generateLogos ({ state, getters, rootGetters, dispatch }) {
    let keywords = rootGetters.companyDetails.split(' ');
    if (keywords.length < 1) {
      dispatch('setErrorMessage', 'Please provide at least 1 keyword.');

      return;
    }

    dispatch('setLogoRecommendations', state.logoRecommendations.concat(Array(recommendedLogosFetchCount).fill({})));
    dispatch('storeLogoInfo', null, { root: true });
    dispatch('updateLoading', true);

    recommendationApi.getRecommendations({
      companyName: rootGetters.companyNameText,
      companyDetails: rootGetters.companyDetails,
      slogan: rootGetters.sloganText,
      paletteCategoriesIds: rootGetters.tickedPaletteCategoriesIds,
      layout: rootGetters.selectedLayouts,
    })
      .then(response => {
        if (response.status === 'success') {
          dispatch('pushLogoRecommendations', response.payload.logos.slice()).then(() => {
            dispatch('updateLoading', false);
          });
        } else if (response.status === 'failure') {
          dispatch('setErrorMessage', response.payload.message).then(() => {
            dispatch('updateLoading', false);
          });
        }
      })
      .catch(error => {
        dispatch('setErrorMessage', error).then(() => {
          dispatch('updateLoading', false);
        });
      });
  },

  refreshLogos({ dispatch }) {
    dispatch('setLogoRecommendations', []);
    dispatch('generateLogos');
  },

  updateLoading ({ commit }, payload) {
    commit('UPDATE_LOADING', payload);
  },

  setErrorMessage ({ commit }, payload) {
    commit('SET_ERROR_MESSAGE', payload);
  },

  removeErrorMessage ({ commit }) {
    commit('SET_ERROR_MESSAGE', '');
  },
};