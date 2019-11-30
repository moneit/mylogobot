import orderApi from "../../services/api/order.js";
import freeDownloadApi from "../../services/api/freeDownload.js";
import lsHelper from "../../helpers/localStorageHelper.js";

export const state = {
    downloadInProgress: false,
};

export const getters = {
    downloadInProgress (state) {
        return state.downloadInProgress;
    },
    loading (state) {
        return state.downloadInProgress;
    },
};

export const mutations = {
    MARK_DOWNLOAD_IN_PROGRESS (state) {
        state.downloadInProgress = true;
    },
    MARK_DOWNLOAD_COMPLETED (state) {
        state.downloadInProgress = false;
    },
};

export const actions = {
    markDownloadInProgress ({ commit }) {
        commit('MARK_DOWNLOAD_IN_PROGRESS');
    },
    markDownloadCompleted ({ commit }) {
        commit('MARK_DOWNLOAD_COMPLETED');
    },
    downloadFromOrder({ dispatch, getters }, payload) {
        if (! getters.downloadInProgress) {
            dispatch('markDownloadInProgress');

            return orderApi.getDownloadLink({
                orderId: payload.orderId,
            })
                .then((res) => {
                    lsHelper.remove('downloadSettings');

                    return res;
                })
                .catch((err) => {
                    console.log('err', err);
                })
                .finally(() => {
                    dispatch('markDownloadCompleted');
                });
        }
    },
    createFreeLogo({ dispatch, getters }, payload) {
        if (! getters.downloadInProgress) {
            dispatch('markDownloadInProgress');

            return freeDownloadApi.create({
                logoId: payload.logoId,
            })
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    console.log('err', err);
                })
                .finally(() => {
                    dispatch('markDownloadCompleted');
                });
        }
    },
    resend({ dispatch, getters }, payload) {
        if (! getters.downloadInProgress) {
            dispatch('markDownloadInProgress');

            return orderApi.resendProduct({
                orderId: payload.orderId,
            })
                .then((res) => {
                    lsHelper.remove('downloadSettings');

                    return res;
                })
                .catch((err) => {
                    console.log('err', err);
                })
                .finally(() => {
                    dispatch('markDownloadCompleted');
                });
        }
    },
};