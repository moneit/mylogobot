import ls from 'local-storage';
import inject from 'vue-inject';
import { STORAGE_KEY, STORAGE_SHARED_KEY } from './state'

const ignoreActions = ['UPDATE_CROSS_TAB'];

const localStoragePlugin = store => {
    store.subscribe((mutation, state) => {

        if(ignoreActions.indexOf(mutation.type) !== 0){
            const syncedData = {
                startDate: state.startDate,
                endDate: state.endDate,
                dateRange: state.dateRange,
                selectedSites: state.selectedSites,
                mediabuysChartSettings: state.mediabuysChartSettings,
                ECPMChartSettings: state.ECPMChartSettings,
                tableOptions: state.tableOptions,
                localStorageVer: state.localStorageVer,
                messagesList: state.messagesList || {},
                filters: state.filters,
            };

            ls.set(STORAGE_KEY, syncedData);

            if (mutation.type === 'CLEAR_ALL_DATA') {
                localStorage.removeItem(STORAGE_KEY);
                localStorage.removeItem(STORAGE_SHARED_KEY);
            }
        }

        switch (mutation.type){
            case 'UPDATE_CROSS_TAB':
                ls.set(STORAGE_SHARED_KEY, state.crossTab);
                break;
        }

    });
};

// export default process.env.NODE_ENV !== 'production' ? [localStoragePlugin] : [localStoragePlugin]
export default [localStoragePlugin];