import request from './responseCacheRequest';

export default {

    store(params, resolve, reject = null) {
        return request('post', '/api/font-recommendations-typography-logo', params, resolve, reject);
    },
}