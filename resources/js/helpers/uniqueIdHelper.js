const uniqueIdHelper = (function() {

    return {
        generate: function() {
            return Math.random().toString(36).substr(2);
        },
    }
})();

export default uniqueIdHelper;