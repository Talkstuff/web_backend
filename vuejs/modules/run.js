require('../bootstrap');

window.routes = window.routes || [];
window.widgets = window.widgets || [];


// todo:: register routes
const router = window.router = new VueRouter({
    linkActiveClass : 'bg-ts fg-white active',
    routes : _.union(routes, [{ path: '*', redirect: '/dashboard' }])
});

// TODO:: register widgets
window.widgets.forEach(function (widget) {
   Vue.component(widget.name, widget.component);
});

Vue.filter('currency', function (value) {
    return accounting.formatMoney(value,'NGN ');
});

Vue.filter('moment', function (value, format) {
    if(format == undefined) format = "dddd, MMM Do YYYY, h:mmA";
    return moment(value).format(format);
});

Vue.filter('slugify', function(value) {
    value = value.replace(/^\s+|\s+$/g, ''); // trim
    value = value.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    var to   = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        value = value.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    value = value.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return value;
});

const app = new Vue({
    el: '#app',
    data : function(){
        return {
            pagination : {
                total : 0,
                per_page : 0,
                current_page : 0,
                loadMoreUrl : null,
            },
            pageTitle : 'talkstuff: Admin',
            system : {
                user : null
            },
            progressBarValue : 0,
            progressBarMax : 100,
            loadingData : true,
            loadingApp : true,
        }
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
        back : function(){
            window.router.go(-1);
        },
        printHtml : function(html){
            var hiddenFrame = $('<iframe style="display: none"></iframe>').appendTo('body')[0];
            hiddenFrame.contentWindow.printAndRemove = function() {
                hiddenFrame.contentWindow.print();
                $(hiddenFrame).remove();
            };
            var htmlDocument = "<!doctype html>"+
                "<html>"+
                "<head>" +
                "<link rel=\"stylesheet\" href=\"/css/print.css\" type=\"text/css\" media=\"print\"/>" +
                "</head>" +
                '<body onload="printAndRemove();">' + // Print only after document is loaded
                html +
                '</body>'+
                "</html>";
            var doc = hiddenFrame.contentWindow.document.open("text/html", "replace");
            doc.write(htmlDocument);
            doc.close();
        },

        load : function(){
            var vm = this;
            this.$http.get('/adminpanel/app/load', {
                before: function(request){
                    vm.$set(vm,'loadingApp', true);
                }
            }).then(
                function(response){
                    Vue.set(vm,'system',response.data);

                    bus.$emit('app-loaded', vm.system);
                    vm.$set(vm,'loadingApp', false);
                },
                function(response){
                    console.log(response.data);
                    vm.notify('Sorry! You have been logged out!', 'error');
                }
            )
        },
        hasPermission : function (permission) {
            var vm = this;
            if(this.system.user){
                // the user is yet to be fetched from the database
                // so wait for the 'app-loaded' events before checking for permission
                return _.contains(this.system.user.privileges, permission);
            } else {
                //console.log('permission: '+permission);

            }
        }
    },
    created : function(){
        var vm = this;
        bus.$on('user-logged-in', function(data){
            //console.log(data);
            window.location.href =  '/adminpanel';
        });

        bus.$on('user-logged-out', function(data){
            window.location.href =  '/adminpanel';
        });

        vm.load();
    },
    router
}).$mount('#app');