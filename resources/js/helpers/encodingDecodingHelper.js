const encodingDecodingHelper = (function() {

  return {
    encode: function(str) {
      return window.btoa(str);
    },

    decode: function(str) {
      return window.atob(str);
    },
  }
})();

export default encodingDecodingHelper;