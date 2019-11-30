import request from './responseCacheRequest';

export default {

    get(params, resolve, reject = null) {
        return request('get', '/api/countries', params, resolve, reject);
    },

    getNames(params, resolve, reject = null) {
        return request('get', '/api/countries/names', params, resolve, reject);
    },
}