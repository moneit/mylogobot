import request from './responseCacheRequest';

export default {

    getUsers(params, resolve, reject = null) {
        return request('get', '/api/users', params, resolve, reject);
    },

    getUser(params, resolve, reject = null) {
        return request('get', '/api/users/details', params, resolve, reject);
    },

    getEmails(params, resolve, reject = null) {
        return request('get', '/api/users/emails', params, resolve, reject); // todo: long term use graphQl
    },

    getNames(params, resolve, reject = null) {
        return request('get', '/api/users/names', params, resolve, reject); // todo: long term use graphQl
    },
}