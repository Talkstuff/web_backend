//window._ = require('lodash');
window._ = require('underscore');
//window.Clipboard = require('clipboard');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

//window.$ = window.jQuery = require('jquery');
//require('eonasdan-bootstrap-datetimepicker');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('vue-resource');

import VueRouter from 'vue-router';
window.VueRouter = VueRouter;

Vue.use(VueRouter);

var VeeValidate =  require('vee-validate');
const config = {
    errorBagName: 'errors', // change if property conflicts.
    delay: 0,
    locale: 'en',
    messages: null,
    strict: true
};
Vue.use(VeeValidate, config);

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push(function(request, next) {
    request.headers.set('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    request.headers.set('X-Requested-With', 'XMLHttpRequest');
    request.headers.set('Content-Type', 'application/json');

    var api_key = $('meta[name="api-key"]').attr('content');

    if(api_key) request.params.api_token = api_key;

    if (this.previousRequest && this.previousRequest.params.searching == true) {
        this.previousRequest.abort();
    }

    // set previous request on Vue instance
    this.previousRequest = request;

    next((response) => {
        if(!response.ok && (!this.previousRequest.params.searching)){
            UIkit.modal.alert(response.body).then(function() {});
        }
    });
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
window.bus = new Vue();