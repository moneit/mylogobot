import request from './responseCacheRequest';

export default {

  getOrders(params, resolve, reject = null) {
    return request('get', '/api/orders', params, resolve, reject);
  },

  getOrder(params, resolve, reject = null) {
    return request('get', '/api/orders/details', params, resolve, reject);
  },

  getDownloadLink(params, resolve, reject = null) {
    return request('post', '/api/orders/' + params.orderId + '/link', params, resolve, reject);
  },

  resendProduct(params, resolve, reject = null) {
    return request('post', '/api/orders/' + params.orderId + '/resend', params, resolve, reject);
  },

  createOrder(params, resolve, reject = null) {
    return request('post', '/api/orders', params, resolve, reject);
  },
}