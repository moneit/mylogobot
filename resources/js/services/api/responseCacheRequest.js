import encodingDecodingHelper from '../../helpers/encodingDecodingHelper.js';

function keygen(method, path, params) {
  return JSON.stringify({method, path, params})
}

function getCache(key) {
  window.lbCache = window.lbCache || {};
  return window.lbCache[key];
}

function setCache(key, data) {
  window.lbCache = window.lbCache || {};
  window.lbCache[key] = data;
}

function decode(encodedData) {
  JSON.parse(encodingDecodingHelper.decode(encodedData))
}

let count = 0;
function increaseRequestCount() {
  count++;
}

function decreaseRequestCount() {
  count--;
}

export function getRequestCount() {
  return count;
}

function internalPolling(cacheKey, timeout) {
  return new Promise(function(resolve, reject) {
    if (timeout > 0) {
      setTimeout(function() {
        let data = getCache(cacheKey);
        if (data) {
          resolve(data);
        } else {
          resolve(internalPolling(cacheKey, timeout - 1));
        }
      }, 1000);
    } else {
      reject('polling timeout');
    }
  });
}

const request = function(method, path, params, successCallback, errorCallback) {
  return new Promise(function(resolve, reject) {
    try{
      if (method === 'get' || method === 'post') { // support only get and post for now, post is sent regardless of cache

        const cacheKey = keygen(method, path, params);

        if (method === 'get') {
          let cachedData = getCache(cacheKey);
          if (cachedData) {
            if (successCallback) {
              // successCallback(decode(cachedData));
              successCallback(cachedData);
            }
            // resolve(decode(cachedData));
            resolve(cachedData);

            return;
          } else if (cachedData === null) {
            internalPolling(cacheKey, 100)
              .then(data => {
                if (successCallback) {
                  // successCallback(decode(data));
                  successCallback(data);
                }
                // resolve(decode(data));
                resolve(data);
              })
              .catch(err => {
                if (errorCallback) {
                  errorCallback(err);
                }
                reject(err);
              });

            return;
          }
        }

        let apiToken = document.head.querySelector('meta[name="api-token"]');

        if (apiToken) {
          params['api_token'] = apiToken.content;
        }

        if (method === 'get') {
          setCache(cacheKey, null); // request is pending
          increaseRequestCount();

          window.axios
            .get(path, {params})
            .then((response) => {
              if (successCallback) {
                // successCallback(decode(response.data));
                successCallback(response.data);
              }
              setCache(cacheKey, response.data);

              // resolve(decode(response.data));
              resolve(response.data);
            })
            .catch((e) => {
              if (errorCallback) {
                errorCallback(e);
              }
              reject(e);
            })
            .finally(() => {
              decreaseRequestCount();
            });
        } else {
          increaseRequestCount();

          window.axios
            .post(path, params)
            .then((response) => {
              if (successCallback) {
                // successCallback(decode(response.data));
                successCallback(response.data);
              }
              // resolve(decode(response.data));
              resolve(response.data);
            })
            .catch((e) => {
              if (errorCallback) {
                errorCallback(e);
              }
              reject(e);
            })
            .finally(() => {
              decreaseRequestCount();
            });
        }
      } else {
        console.log('Exception: unexpected request method - ', method);
      }
    } catch (e) {
      console.log('api failed (method: ' + method + ', path: ' + path + ', params: ', params, ')', e);
      if (errorCallback) {
        errorCallback(e);
      }
      reject(e);
    }
  });
};

export default request;