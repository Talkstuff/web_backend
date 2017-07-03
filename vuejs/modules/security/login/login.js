
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../../bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

const app = new Vue({
    el: '#app',
    data : function(){
        return {
            loadingApp : true
        }
    },
    components : {
        'login' : require('./Login.vue')
    },
    methods : {
        notify : function(message, type){
            UIkit.notification.closeAll();

            UIkit.notification({
                message: message,
                status: type,
                pos: 'top-center',
                timeout: 5000
            });
        },
    },
    created : function(){
        bus.$on('user-logged-in', function(){
            window.location.href = '/adminpanel';
        });
    }
});
