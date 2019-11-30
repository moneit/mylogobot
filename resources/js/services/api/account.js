import request from './responseCacheRequest';

export default {

    get(params, resolve, reject = null) {
        return request('get', '/api/account', params, resolve, reject);
    },
}