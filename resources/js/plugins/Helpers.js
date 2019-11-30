const Helpers = {

    install(Vue, options){

        Vue.snakeToCamel = function (s) {
            return s.replace(/(\-\w)/g, function(m){ return m[1].toUpperCase(); });
        };

        Vue.capitalizeString = function (s) {
            return s.replace(/\w\S*/g, function(word){ return word.charAt(0).toUpperCase() + word.substr(1).toLowerCase(); });
        };

        Vue.hexToRgb = function (hex) {
            if (typeof hex !== 'string') return null;

            let r = hex.substr(1, 2);
            let g = hex.substr(3, 2);
            let b = hex.substr(5, 2);

            return {
                r: parseInt(r, 16),
                g: parseInt(g, 16),
                b: parseInt(b, 16),
            }
        };

        Vue.isMobile = function () {
            return window.innerWidth < 576;
        };

        Vue.isDesktop = function () {
            return window.innerWidth > 767;
        };
    }
};

export default Helpers;