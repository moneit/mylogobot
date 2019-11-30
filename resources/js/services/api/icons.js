import request from './responseCacheRequest';

export default {

    getIcons(params, resolve, reject = null) {
        return request('post', '/api/icon/list', params, resolve, reject);
    },

    getIconInfoByUrl(params, resolve, reject = null) {
        return request('get', '/api/icon/paths', params, resolve, reject);
    },
}