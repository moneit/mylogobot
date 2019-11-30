import request from './responseCacheRequest';

export default {

    getList (params, resolve, reject = null) {
        return request('get', '/api/color/list', params, resolve, reject);
    },

    getPalette (params, resolve, reject = null) {
        return request('get', '/api/color/palette', params, resolve, reject);
    },

    getColorCategories (params, resolve, reject = null) {
        return request('get', '/api/color/categories', params, resolve, reject);
    },
}