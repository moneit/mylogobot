import request from './responseCacheRequest';

export default {

    get(params, resolve, reject = null) {
        return request('get', '/api/packages', params, resolve, reject);
    },

    getNames(params, resolve, reject = null) {
        return request('get', '/api/packages/names', params, resolve, reject);
    },
}