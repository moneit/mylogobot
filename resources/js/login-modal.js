function onSuccess(googleUser) {
    console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
}
function onFailure(error) {
    console.log(error);
}
function renderButton() {
    gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 286,
        'height': 47,
        'longtitle': true,
        'theme': 'light',
        'onsuccess': onSuccess,
        'onfailure': onFailure
    });
}

// if (Vue === undefined) {
    const Vue = require('vue');
// }

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('form-input', require('./components/FormInput.vue').default);

const loginModalApp = new Vue({
    el: '#login-modal',
});

const resetPasswordModalApp = new Vue({
    el: '#reset-password-modal',
});