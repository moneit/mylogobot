import { CONVERSATION_PAGE } from './pages.js';
import { RECOMMENDATIONS_PAGE } from './pages.js';
import { LANDING_PAGE } from './pages.js';

const router = (function() {

    const pathToPageMap = {
        '/conversation': CONVERSATION_PAGE,
        '/recommendations': RECOMMENDATIONS_PAGE,
        '/': LANDING_PAGE,
    };

    const pageToPathMap = {
        [CONVERSATION_PAGE]: '/conversation',
        [RECOMMENDATIONS_PAGE]: '/recommendations',
        [LANDING_PAGE]: '/',
    };

    return {
        getPageFromPath: function(path) {
            return pathToPageMap[path];
        },
        goToPath: function(path) {
            window.location = window.location.origin + path;
        },
        goToPage: function(page) {
            window.location = window.location.origin + pageToPathMap[page];
        },
    };
})();

export default router;