import request from './responseCacheRequest';

export default {

    intent(params, resolve, reject = null) {
        return request('post', '/api/payment/intent', params, resolve, reject);
    },

    confirm(params, resolve, reject = null) {
        return request('post', '/api/payment/confirm', params, resolve, reject);
    },

    verifyPaypalTransaction(params, resolve, reject = null) {
        return request('post', '/api/payment/verify-paypal-transaction', params, resolve, reject);
    },
}