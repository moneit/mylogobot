import request from './responseCacheRequest';

export default {

    store (params, resolve, reject = null) {
        return request('post', '/api/color-palette', params, resolve, reject);
    },
}