import historyHelper from '../helpers/historyHelper.js';

export default { // this mixin requires store attached
  data() {
    return {
      backLink: false,
    }
  },
  watch: {
    backLink() {
      this.goBack();
    }
  },
  methods: {
    goBack() { // this method is able to be overridden
      historyHelper.goToPreviousPage();
    },

    getHistoryData() {
      return historyHelper.extractHistoryData();
    },

    storeHistoryData(data) {
      historyHelper.pushOrUpdateHistoryData(data);
    },
  },
};