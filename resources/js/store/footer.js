import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {};

const getters = {};

const mutations = {};

export const actions = {};

const requiredModuleNames = ['recommendation'];

// Load store modules dynamically.
const requireContext = require.context('./modules', false, /.*\.js$/);

const modules = requireContext.keys()
    .map(file =>
        [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
    )
    .reduce((modules, [name, module]) => {
        if (requiredModuleNames.includes(name)) {
            if (module.namespaced === undefined) {
                module.namespaced = true
            }

            return { ...modules, [name]: module }
        } else {

            return modules;
        }
    }, {});

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
    modules,
    // plugins
})