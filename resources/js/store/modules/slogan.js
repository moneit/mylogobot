import fontApi from '../../services/api/fonts';

export const state = {
    id: 0,
    text: '',
    fontSize: 10,
    fontBounds: {
        'minX': 0,
        'minY': 0,
        'maxX': 0,
        'maxY': 0,
    },
    fontAdvX: 0,
    letterSpace: 0,
    lineSpace: 50,
    font: {},
    color: {
        hex: '#D9D525',
        rgba: { r: 217, g: 213, b: 37, a: 1 },
        a: 1
    },
    capitalization: '',
    paths: [],
    width: 0,
    height: 0,
    scale: 1,

    loading: false,
};

export const getters = {
    width(state) {
        return state.width * state.scale;
    },

    height(state) {
        return state.height * state.scale;
    },

    lineSpaceRate(state) {
        return (state.lineSpace - 50) / 50;
    },

    color(state) {
        return state.color;
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

    UPDATE_TEXT (state, payload) {
        state.text = payload;
    },

    UPDATE_FONT_SIZE (state, payload) {
        state.fontSize = Number(payload);
    },

    UPDATE_FONT_BOUNDS (state, payload) {
        state.fontBounds = payload;
    },

    UPDATE_FONT_ADV_X (state, payload) {
        state.fontAdvX = payload;
    },

    UPDATE_LETTER_SPACE (state, payload) {
        state.letterSpace = Number(payload);
    },

    UPDATE_LINE_SPACE (state, payload) {
        state.lineSpace = Number(payload);
    },

    UPDATE_FONT (state, payload) {
        state.font = payload;
    },

    UPDATE_COLOR (state, payload) {
        state.color = payload;
    },

    UPDATE_CAPITALIZATION (state, payload) {
        state.capitalization = payload;
    },

    UPDATE_PATHS (state, payload) {
        state.paths = payload;
    },

    UPDATE_WIDTH (state, payload) {
        state.width = payload;
    },

    UPDATE_HEIGHT (state, payload) {
        state.height = payload;
    },

    UPDATE_SCALE (state, payload) {
        state.scale = payload;
    },

    UPDATE_LOADING (state, payload) {
        state.loading = payload;
    },
};

export const actions = {

    updateId ({ commit }, payload) {
        commit('UPDATE_ID', payload);
    },

    updateText ({ commit, dispatch }, payload) {
        commit('UPDATE_TEXT', payload);
        dispatch('updatePaths');
    },

    updateFontSize ({ commit }, payload) {
        commit('UPDATE_FONT_SIZE', payload);
    },

    updateFontBounds ({ commit }) {
        return new Promise(function(resolve, reject) {
            fontApi.getBounds({
                fontId: state.font.id,
            }, (data) => {
                if (data.status === 'success') {
                    commit('UPDATE_FONT_BOUNDS', data.payload.bounds);
                    resolve();
                }
            }, (error) => {
                reject(error);
            });
        });
    },

    updateFontAdvX ({ state, commit }) {
        return new Promise(function(resolve, reject) {
            fontApi.getHorizAdvX({
                fontId: state.font.id,
            }, (data) => {
                if (data.status === 'success') {
                    commit('UPDATE_FONT_ADV_X', data.payload.globalAdvX);
                    resolve();
                }
            }, (error) => {
                reject(error);
            });
        });
    },

    updateLetterSpace ({ commit }, payload) {
        commit('UPDATE_LETTER_SPACE', payload);
    },

    updateLineSpace ({ commit }, payload) {
        commit('UPDATE_LINE_SPACE', payload);
    },

    updateFont ({ commit, dispatch }, payload) {
        return new Promise(function(resolve, reject) {
            if (typeof payload === 'object') {
                commit('UPDATE_FONT', payload);

                Promise.all([
                    dispatch('updateFontBounds'),
                    dispatch('updateFontAdvX'),
                    dispatch('updatePaths'),
                ])
                    .then(() => {
                        resolve();
                    })
                    .catch(() => {
                        reject();
                    });
            } else {
                reject();
            }
        });
    },

    updateColor ({ commit }, payload) {
        commit('UPDATE_COLOR', payload);
    },

    updateCapitalization ({ commit, dispatch }, payload) {
        commit('UPDATE_CAPITALIZATION', payload);
        dispatch('updatePaths');
    },

    updatePaths ({ commit }) {
        return new Promise(function(resolve, reject) {
            if (state.text) { // reduce unnecessary api call
                fontApi.getPaths({
                    string: state.text,
                    capitalization: state.capitalization,
                    fontId: state.font.id,
                }, (data) => {
                    if (data.status === 'success') {
                        commit('UPDATE_PATHS', data.payload.paths);
                        resolve();
                    }
                }, (error) => {
                    reject(error)
                });
            } else {
                commit('UPDATE_PATHS', []);
                resolve();
            }
        });
    },

    updateWidth ({ commit }, payload) {
        commit('UPDATE_WIDTH', payload);
    },

    updateHeight ({ commit }, payload) {
        commit('UPDATE_HEIGHT', payload);
    },

    updateScale ({ commit }, payload) {
        commit('UPDATE_SCALE', payload);
    },

    updateLoading ({ commit }, payload) {
        commit('UPDATE_LOADING', payload);
    },

    initFont ({ state, dispatch }, payload) {
        if (! state.font.id) {
            dispatch('updateFont', payload);
        }
    },

    cloneSettings ({ commit }, payload) {
        return new Promise(function(resolve, reject) {
            commit('UPDATE_ID', payload.id);
            commit('UPDATE_TEXT', payload.text);
            commit('UPDATE_FONT_SIZE', payload.fontSize);
            commit('UPDATE_FONT_BOUNDS', payload.fontBounds);
            commit('UPDATE_FONT_ADV_X', payload.fontAdvX);
            commit('UPDATE_LETTER_SPACE', payload.letterSpace);
            commit('UPDATE_LINE_SPACE', payload.lineSpace);
            commit('UPDATE_FONT', payload.font);
            commit('UPDATE_COLOR', payload.color);
            commit('UPDATE_CAPITALIZATION', payload.capitalization);
            commit('UPDATE_PATHS', payload.paths);
            commit('UPDATE_WIDTH', payload.width);
            commit('UPDATE_HEIGHT', payload.height);
            commit('UPDATE_SCALE', payload.scale);

            resolve();
        });
    }
};
