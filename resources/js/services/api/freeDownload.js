import request from './responseCacheRequest';

export default {

    create(params, resolve, reject = null) {
        return request('post', '/api/free-downloads', params, resolve, reject);
    },
}