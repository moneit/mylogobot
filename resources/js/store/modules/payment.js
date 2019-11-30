export const state = {
    paymentInProgress: false,
};

export const getters = {
    paymentInProgress (state) {
        return state.paymentInProgress;
    },
    loading (state) {
        return state.paymentInProgress;
    },
};

export const mutations = {
    MARK_PAYMENT_IN_PROGRESS (state) {
        state.paymentInProgress = true;
    },
    MARK_PAYMENT_COMPLETED (state) {
        state.paymentInProgress = false;
    },
};

export const actions = {
    markPaymentInProgress ({ commit }) {
        commit('MARK_PAYMENT_IN_PROGRESS');
    },
    markPaymentCompleted ({ commit }) {
        commit('MARK_PAYMENT_COMPLETED');
    },
};