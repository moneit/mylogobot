import request from './responseCacheRequest';

export default {

  get(params, resolve, reject = null) {
    return request('get', '/api/logo', params, resolve, reject);
  },

  getSettings(params, resolve, reject = null) {
    return request('get', `/api/logo/${params.logoId}/settings`, params, resolve, reject);
  },

  save(params, resolve, reject = null) {
    return request('post', '/api/logo', params, resolve, reject);
  },

  getSavedLogos(params, resolve, reject = null) {
    return request('get', '/api/logo/saved', params, resolve, reject);
  },
}