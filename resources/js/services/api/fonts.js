import request from './responseCacheRequest';

export default {

    getPaths(params, resolve, reject = null) {
        return request('get', '/api/font/paths', params, resolve, reject);
    },

    getBounds(params, resolve, reject = null) {
        return request('get', '/api/font/bounds', params, resolve, reject);
    },

    getHorizAdvX(params, resolve, reject = null) {
        return request('get', '/api/font/horiz-adv-x', params, resolve, reject);
    },

    getList(params, resolve, reject = null) {
        return request('get', '/api/font/list', params, resolve, reject);
    },
}