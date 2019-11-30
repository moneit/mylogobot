import request from './responseCacheRequest';

export default {

  get (params, resolve, reject = null) {
    return request('get', '/api/recommendation-tracks', params, resolve, reject);
  },
}