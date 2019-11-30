import containerApi from '../../services/api/containers';

export const state = {
    id: 0, // id of pivot table
    types: [
        {
            label: 'Filled',// also used as key of type
            icon: 'icon-certificate',
            selected: true,
        },
        {
            label: 'Outlined',
            icon: 'icon-certificate-outline',
        },
    ],
    list: [],
    shapes: [],
    color: {
        hex: '#194d33',
        rgba: { r: 25, g: 77, b: 51, a: 1 },
        a: 1
    },
    size: 50,
    selected: {},
    viewBox: {
        maxX: 0,
        maxY: 0,
        minX: 0,
        minY: 0,
    },

    loading: false,
};

export const getters = {
    type (state) {
        return state.types.find(type => type.selected);
    },

    scale (state, getters, rootState) {
        if (state.viewBox.maxX - state.viewBox.minX === 0) {
            return 1;
        } else {
            return rootState.width / 100 * state.size / (state.viewBox.maxX - state.viewBox.minX);
        }
    },

    width(state, getters) {
        return (state.viewBox.maxX - state.viewBox.minX) * getters.scale;
    },

    height(state, getters) {
        return (state.viewBox.maxY - state.viewBox.minY) * getters.scale;
    },

    loading (state) {
        return state.loading;
    },

    settings (state) {
        let settings = JSON.parse(JSON.stringify(state));
        delete settings.loading;

        return settings;
    },
};

export const mutations = {

    UPDATE_ID (state, payload) {
        state.id = payload;
    },

    UPDATE_TYPES (state, payload) {
        state.types = payload;
    },

    UPDATE_LIST (state, payload) {
        state.list = payload;
    },

    UPDATE_SHAPES (state, payload) {
        state.shapes = payload;
    },

    UPDATE_COLOR (state, payload) {
        state.color = payload;
    },

    UPDATE_SIZE (state, payload) {
        state.size = Number(payload);
    },

    UPDATE_SELECTED (state, payload) {
        state.selected = payload;
    },

    UPDATE_VIEW_BOX (state, payload) {
        state.viewBox = payload;
    },

    UPDATE_LOADING (state, payload) {
        state.loading = payload;
    },
};

export const actions = {

    updateId ({ commit }, payload) {
        commit('UPDATE_ID', payload);
    },

    updateType ({ state, commit }, payload) {
        commit('UPDATE_TYPES', state.types.map((type) => {
            if (type.label === payload.label) {
                type.selected = true;
            } else {
                if (type.selected) {
                    commit('UPDATE_LIST', []);
                    type.selected = false;
                }
            }
            return type;
        }));

        containerApi.getList({
            filled: Number(payload.label === 'Filled')
        }, (data) => {
            if (data.status === 'success') {
                commit('UPDATE_LIST', data.payload.list);
            }
        });
    },

    updateColor ({ commit }, payload) {
        commit('UPDATE_COLOR', payload);
    },

    updateSize ({ commit }, payload) {
        commit('UPDATE_SIZE', payload);
    },

    updateSelected ({ commit }, payload) {
        commit('UPDATE_SELECTED', payload);

        if (! payload.id) {
            commit('UPDATE_SHAPES', []);
            commit('UPDATE_VIEW_BOX', {
                maxX: 0,
                maxY: 0,
                minX: 0,
                minY: 0,
            });
        } else {
            containerApi.getData({
                id: payload.id
            }, (data) => {
                if (data.status === 'success') {
                    commit('UPDATE_SHAPES', data.payload.shapes);
                    commit('UPDATE_VIEW_BOX', data.payload.viewBox);
                }
            });
        }
    },

    updateLoading ({ commit }, payload) {
        commit('UPDATE_LOADING', payload);
    },

    initContainers ({ getters, dispatch }) {
        dispatch('updateType', getters.type);
    },

    cloneSettings ({ commit }, payload) {
        return new Promise(function(resolve, reject) {
            commit('UPDATE_ID', payload.id);
            commit('UPDATE_TYPES', payload.types);
            commit('UPDATE_LIST', payload.list);
            commit('UPDATE_SHAPES', payload.shapes);
            commit('UPDATE_COLOR', payload.color);
            commit('UPDATE_SIZE', payload.size);
            commit('UPDATE_SELECTED', payload.selected);
            commit('UPDATE_VIEW_BOX', payload.viewBox);

            resolve();
        });
    }
};
