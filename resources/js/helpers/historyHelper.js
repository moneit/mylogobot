import router from '../services/routing/router.js';
import lsHelper from './localStorageHelper';
import store from '../store';

const historyHelper = (function() {

  const path = window.location.pathname;

  let historyStack = (lsHelper.get('history')).stack || [];

  const getHistory = function() {
    if (Array.isArray(historyStack) && historyStack.length) {
      return historyStack[historyStack.length - 1];
    }

    return null;
  };

  const syncLocalStorage = function() {
    lsHelper.set('history', {
      stack: historyStack,
    });
  };

  return {
    extractHistoryData() {
      let history = getHistory();
      if (! history) return;

      if (history.active) {
        history.active = false;
        syncLocalStorage();

        if (history.path === path) {
          return history.data;
        }
      } else {
        if (window.performance) { // when browser back button is clicked
          let navEntries = window.performance.getEntriesByType('navigation');
          if (navEntries.length > 0 && navEntries[0].type === 'back_forward') {
            history.active = true;
          } else if (window.performance.navigation && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
            history.active = true;
          }
        }

        if (history.active) {
          historyStack.pop();
          syncLocalStorage();
          history = getHistory();

          if (! history) return;

          if (history.path === path) {
            return history.data;
          }
        } else {
          if (!history.auth && store.getters.isAuthenticated && history.path === '/recommendations' && history.path === path) {// todo : think about design pattern
            return history.data; // exception for recommendations page
          }
        }
      }
    },

    goToPreviousPage: function() {
      historyStack.pop();// if history data of current page is added already, pop it first
      syncLocalStorage();

      let history = getHistory();
      if (! history) return window.history.back();

      history.active = true;
      syncLocalStorage();

      router.goToPath(history.path);
    },

    pushOrUpdateHistoryData(data) { // history data is able to push only once in 1 page(path)
      let history = getHistory();

      if (history && history.path === path) { // update
        history.data = data;
      } else { // push
        if (historyStack.length >= 6) { // max depth of history stack is 6
          historyStack = historyStack.slice(historyStack.length - 5); // leave only 5 history data
        }
        historyStack.push({
          path: path,
          active: false,
          data: data,
          auth: store.getters.isAuthenticated,
        });
      }

      syncLocalStorage();
    },
  }
})();

export default historyHelper;