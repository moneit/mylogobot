import Vue from 'vue';
import Vuex from 'vuex';
import lsHelper from "../helpers/localStorageHelper";

Vue.use(Vuex);

const state = {
    companyNameText: ''
};

const getters = {};

const mutations = {
    UPDATE_COMPANY_NAME_TEXT (state, payload) {
        state.companyNameText = payload;
    },
};

export const actions = {
    updateCompanyNameText ({ commit }, payload) {
        commit('UPDATE_COMPANY_NAME_TEXT', payload);
    },

    storeLogoInfo ({ state }) {
        lsHelper.set('logoInfo', {
            companyName: state.companyNameText,
            companyDetails: '',
            slogan: '',
            layout: '',
            colorCategoriesIds: [],
        });
    }
};

// const requiredModuleNames = [];
//
// // Load store modules dynamically.
// const requireContext = require.context('./modules', false, /.*\.js$/);
//
// const modules = requireContext.keys()
//     .map(file =>
//         [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
//     )
//     .reduce((modules, [name, module]) => {
//         if (requiredModuleNames.includes(name)) {
//             if (module.namespaced === undefined) {
//                 module.namespaced = true
//             }
//
//             return { ...modules, [name]: module }
//         } else {
//
//             return modules;
//         }
//     }, {});

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
    // modules,
    // plugins,
})