const localStorageHelper = (function() {

  const store = require('store');
  const STORAGE_KEY = 'muhammadWebAvenue';
  const getStoreData = function() {

    let storeData = store.get(STORAGE_KEY) || {};
    if (typeof storeData === 'string') {
      store.set(STORAGE_KEY, {});

      return {};
    }

    return storeData;
  };

  return {
    set: function(key, data) {

      let storeData = getStoreData();
      storeData[key] = Object.assign({}, storeData[key], data);

      store.set(STORAGE_KEY, storeData);
    },
    get: function(key) {

      return getStoreData()[key] || {};
    },
    remove: function(key) {

      let storeData = getStoreData();
      storeData[key] = undefined;

      store.set(STORAGE_KEY, storeData);
    }
  }
})();

export default localStorageHelper;