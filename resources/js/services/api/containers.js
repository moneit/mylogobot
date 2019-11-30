import request from './responseCacheRequest';

export default {

    getList (params, resolve, reject = null) {
        return request('get', '/api/container/list', params, resolve, reject);
    },

    getData (params, resolve, reject = null) {
        return request('get', '/api/container/data', params, resolve, reject);
    },
}