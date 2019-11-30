import iconApi from '../../services/api/icons';
import fontApi from '../../services/api/fonts';

export const state = {
    types: [
        {
            label: 'Icon',// also used as key of type
            icon: 'logobot-icon icon-gem',
            selected: true,
        },
        {
            label: 'Initials',
            icon: 'logobot-icon icon-heading',
        },
    ],

    iconId: 0,
    tags: [],
    iconBounds: {
        'minX': 0,
        'minY': 0,
        'maxX': 0,
        'maxY': 0,
    },
    iconClipRule: '',
    iconFillRule: '',
    iconSize: 20,
    iconWidth: 0,
    iconHeight: 0,
    iconScale: 1,
    iconHidden: false,

    initialsId: 0,
    font: {},
    fontSize: 10,
    fontBounds: {
        'minX': 0,
        'minY': 0,
        'maxX': 0,
        'maxY': 0,
    },
    fontAdvX: 0,
    text: '',
    paths: [],
    letterSpace: 0,
    initialsWidth: 0,
    initialsHeight: 0,
    initialsScale: 1,

    color: {
        hex: '#D9D525',
        rgba: { r: 217, g: 213, b: 37, a: 1 },
        a: 1
    },
    lineSpace: 50,

    loading: false,
};

export const getters = {
    type(state) {
        return state.types.find(type => type.selected);
    },

    isPlaced(state, getters) {
        return (getters.type.label === 'Icon' && !state.iconHidden && state.tags.length) || (getters.type.label === 'Initials' && state.text);
    },

    width(state, getters) {
        if (getters.isPlaced) {
            if (state.types[0].selected) { // icons
                return state.iconWidth * state.iconScale;
            } else {
                return state.initialsWidth * state.initialsScale;
            }
        } else {
            return 0;
        }
    },

    height(state) {
        if (getters.isPlaced) {
            if (state.types[0].selected) { // icons
                return state.iconHeight * state.iconScale;
            } else {
                return state.initialsHeight * state.initialsScale;
            }
        } else {
            return 0;
        }
    },

    scale(state) {
        if (state.types[0].selected) { // icons
            return state.iconScale;
        } else {
            return state.initialsScale;
        }
    },

    color(state) {
        return state.color;
    },

    lineSpaceRate(state) {
        return (state.lineSpace - 50) / 50;
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

    UPDATE_TYPES (state, payload) {
        state.types = payload;
    },

    UPDATE_TYPE (state, payload) {
        state.types.forEach((type) => {
            if (type.label === payload.label) {
                type.selected = true;
            } else {
                type.selected = false;
            }
        });
    },

    // icon
    UPDATE_ICON_ID (state, payload) {
        state.iconId = payload;
    },

    UPDATE_TAGS (state, payload) {
        state.tags = payload;
    },

    UPDATE_ICON_BOUNDS (state, payload) {
        state.iconBounds = payload;
    },

    UPDATE_CLIP_RULE (state, payload) {
        state.iconClipRule = payload;
    },

    UPDATE_FILL_RULE (state, payload) {
        state.iconFillRule = payload;
    },

    UPDATE_ICON_SIZE (state, payload) {
        state.iconSize = payload;
    },

    UPDATE_ICON_WIDTH (state, payload) {
        state.iconWidth = payload;
    },

    UPDATE_ICON_HEIGHT (state, payload) {
        state.iconHeight = payload;
    },

    UPDATE_ICON_SCALE (state, payload) {
        state.iconScale = payload;
    },

    UPDATE_ICON_HIDDEN (state, payload) {
        state.iconHidden = !!payload;
    },

    // initials
    UPDATE_INITIALS_ID (state, payload) {
        state.initialsId = payload;
    },

    UPDATE_FONT (state, payload) {
        state.font = payload;
    },

    UPDATE_FONT_SIZE (state, payload) {
        state.fontSize = payload;
    },

    UPDATE_FONT_BOUNDS (state, payload) {
        state.fontBounds = payload;
    },

    UPDATE_FONT_ADV_X (state, payload) {
        state.fontAdvX = payload;
    },

    UPDATE_TEXT (state, payload) {
        state.text = payload;
    },

    UPDATE_PATHS (state, payload) {
        state.paths = payload;
    },

    UPDATE_LETTER_SPACE (state, payload) {
        state.letterSpace = payload;
    },

    UPDATE_INITIALS_WIDTH (state, payload) {
        state.initialsWidth = payload;
    },

    UPDATE_INITIALS_HEIGHT (state, payload) {
        state.initialsHeight = payload;
    },

    UPDATE_INITIALS_SCALE (state, payload) {
        state.initialsScale = payload;
    },

    // common properties
    UPDATE_COLOR (state, payload) {
        state.color = payload;
    },

    UPDATE_LINE_SPACE (state, payload) {
        state.lineSpace = Number(payload);
    },

    UPDATE_LOADING (state, payload) {
        state.loading = payload;
    },
};

// actions
export const actions = {

    updateTypes ({ commit }, payload) {
        commit('UPDATE_TYPES', payload);
    },

    updateType ({ commit }, payload) {
        commit('UPDATE_TYPE', payload);
    },

    updateIconId ({ commit }, payload) {
        commit('UPDATE_ICON_ID', payload);
    },

    updateIcon ({ state, commit }, payload) {
        if (!state.loading && payload) {
            commit('UPDATE_LOADING', true);

            return iconApi.getIconInfoByUrl({
                url: payload
            })
                .then((data) => {
                    if (data.status === 'success') {
                        let tags = data.payload.tags.map(tag => tag.replace('fill:black', 'fill:"' + state.color.hex + '"'));// remove black fill
                        tags = tags.map(tag => tag.replace('fill="black"', 'fill="' + state.color.hex + '"'));// remove black fill

                        tags = tags.map(tag => tag.replace(/fill="#[0-9|a-f]{3}"/gi, 'fill="' + state.color.hex + '"'));// remove inline fills
                        tags = tags.map(tag => tag.replace(/fill="#[0-9|a-f]{6}"/gi, 'fill="' + state.color.hex + '"'));// remove inline fills

                        tags = tags.map(tag => tag.replace(/stroke="#[0-9|a-f|A-F]{3}"/gi, 'stroke="' + state.color.hex + '"'));// remove inline stroke
                        tags = tags.map(tag => tag.replace(/stroke="#[0-9|a-f|A-F]{6}"/gi, 'stroke="' + state.color.hex + '"'));// remove inline stroke

                        tags = tags.map(tag => tag.replace(/fill:#[0-9|a-f]{3};/gi, 'fill:' + state.color.hex + ';'));// remove css fills
                        tags = tags.map(tag => tag.replace(/fill:#[0-9|a-f]{6};/gi, 'fill:' + state.color.hex + ';'));// remove css fills

                        tags = tags.map(tag => tag.replace(/stroke:#[0-9|a-f|A-F]{3};/gi, 'stroke:' + state.color.hex + ';'));// remove css stroke
                        tags = tags.map(tag => tag.replace(/stroke:#[0-9|a-f|A-F]{6};/gi, 'stroke:' + state.color.hex + ';'));// remove css stroke

                        commit('UPDATE_TAGS', tags);
                        commit('UPDATE_ICON_BOUNDS', data.payload.iconBounds);
                        if (data.payload.attributes['clip-rule']) {
                            commit('UPDATE_CLIP_RULE', data.payload.attributes['clip-rule']);
                        } else {
                            commit('UPDATE_CLIP_RULE', '');
                        }
                        if (data.payload.attributes['fill-rule']) {
                            commit('UPDATE_FILL_RULE', data.payload.attributes['fill-rule']);
                        } else {
                            commit('UPDATE_FILL_RULE', '');
                        }
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
                .finally(() => {
                    commit('UPDATE_LOADING', false);
                });
        } else {
            commit('UPDATE_TAGS', data.payload.tags);
            commit('UPDATE_ICON_BOUNDS', data.payload.iconBounds);
        }
    },

    updateIconSize ({ commit }, payload) {
        commit('UPDATE_ICON_SIZE', payload);
    },

    updateIconWidth ({ commit }, payload) {
        commit('UPDATE_ICON_WIDTH', payload);
    },

    updateIconHeight ({ commit }, payload) {
        commit('UPDATE_ICON_HEIGHT', payload);
    },

    updateIconScale ({ commit }, payload) {
        commit('UPDATE_ICON_SCALE', payload);
    },

    updateIconHidden ({ commit }, payload) {
        commit('UPDATE_ICON_HIDDEN', payload);
    },

    updateInitialsId ({ commit }, payload) {
        commit('UPDATE_INITIALS_ID', payload);
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

    updateFontSize ({ commit }, payload) {
        commit('UPDATE_FONT_SIZE', payload);
    },

    updateFontBounds ({ state, commit }) {
        return new Promise(function(resolve, reject) {
            fontApi.getBounds({
                fontId: state.font.id,
                capitalization: 'uppercase' // always use uppercase for initials
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

    updateText ({ commit, dispatch }, payload) {
        commit('UPDATE_TEXT', payload);
        dispatch('updatePaths');
    },

    updatePaths ({ commit }) {
        return new Promise(function(resolve, reject) {
            fontApi.getPaths({
                string: state.text,
                capitalization: '',
                fontId: state.font.id,
            }, (data) => {
                if (data.status === 'success') {
                    commit('UPDATE_PATHS', data.payload.paths);
                    resolve();
                }
            }, (error) => {
                reject(error)
            });
        });
    },

    updateInitialsWidth ({ commit }, payload) {
        commit('UPDATE_INITIALS_WIDTH', payload);
    },

    updateInitialsHeight ({ commit }, payload) {
        commit('UPDATE_INITIALS_HEIGHT', payload);
    },

    updateInitialsScale ({ commit }, payload) {
        commit('UPDATE_INITIALS_SCALE', payload);
    },

    updateColor ({ commit, state }, payload) {
        if (payload.hex) { // apply color to tags
            if (state.tags) { // to fix use tag with href
                state.tags = state.tags.map(tag => tag.replace(new RegExp(state.color.hex ,"g"), payload.hex));
            }
        }
        commit('UPDATE_COLOR', payload);
    },

    updateLineSpace ({ commit }, payload) {
        commit('UPDATE_LINE_SPACE', payload);
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
            commit('UPDATE_TYPES', payload.types);
            commit('UPDATE_ICON_ID', payload.iconId);
            commit('UPDATE_TAGS', payload.tags);
            commit('UPDATE_ICON_BOUNDS', payload.iconBounds);
            commit('UPDATE_ICON_SIZE', payload.iconSize);
            commit('UPDATE_ICON_WIDTH', payload.iconWidth);
            commit('UPDATE_ICON_HEIGHT', payload.iconHeight);
            commit('UPDATE_ICON_SCALE', payload.iconScale);
            commit('UPDATE_ICON_HIDDEN', payload.iconHidden);
            commit('UPDATE_INITIALS_ID', payload.initialsId);
            commit('UPDATE_FONT', payload.font);
            commit('UPDATE_FONT_SIZE', payload.fontSize);
            commit('UPDATE_FONT_BOUNDS', payload.fontBounds);
            commit('UPDATE_FONT_ADV_X', payload.fontAdvX);
            commit('UPDATE_TEXT', payload.text);
            commit('UPDATE_PATHS', payload.paths);
            commit('UPDATE_LETTER_SPACE', payload.letterSpace);
            commit('UPDATE_INITIALS_WIDTH', payload.initialsWidth);
            commit('UPDATE_INITIALS_HEIGHT', payload.initialsHeight);
            commit('UPDATE_INITIALS_SCALE', payload.initialsScale);
            commit('UPDATE_COLOR', payload.color);
            commit('UPDATE_LINE_SPACE', payload.lineSpace);

            resolve();
        });
    }
};
