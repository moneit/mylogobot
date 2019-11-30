import request from './responseCacheRequest';

export default {

    getRecommendations (params, resolve, reject = null) {
        return request('post', '/api/recommendations', params, resolve, reject);
    },
}