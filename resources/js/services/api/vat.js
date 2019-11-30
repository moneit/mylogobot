import request from './responseCacheRequest';

export default {

    order(params, resolve, reject = null) {
        return request('post', '/api/payment/order', params, resolve, reject);
    },
}