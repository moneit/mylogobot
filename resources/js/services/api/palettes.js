import request from './responseCacheRequest';

export default {

    store (params, resolve, reject = null) {
        return request('post', '/api/palettes', params, resolve, reject);
    },
}