import request from './responseCacheRequest';

export default {

    apply(params, resolve, reject = null) {
        return request('post', '/api/coupon/apply', params, resolve, reject);
    },
}