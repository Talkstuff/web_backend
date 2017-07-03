window.routes = window.routes || [];
window.widgets = window.widgets || [];

(function () {
    var moduleRoutes = [
        { path: '/users', name : 'users', component: require('./components/Users.vue') },
        { path: '/users/new', name : 'users.new', component: require('./components/NewUser.vue') },

        { path: '/users/:userId/details',
            name: 'users.details',
            component: require('./components/Details.vue'),
            beforeEnter: function (to, from, next) {
                next(function (vm) {
                    if(!vm.$root.hasPermission('USER_MANAGE_DETAILS')){
                        return false;
                    }
                    return true;
                });
            },
            children: [
                {
                    path: 'home',
                    name: 'users.details.home',
                    component: require('./components/details/UserHomeScreen.vue'),
                },
                {
                    path: 'edit',
                    name: 'users.details.edit',
                    component: require('./components/NewUser.vue'),
                },
                {
                    path: 'permissions',
                    name: 'users.details.permissions',
                    component: require('./components/details/UserRoles.vue'),
                },
                {
                    path: 'roles',
                    name: 'users.details.roles',
                    component: require('./components/details/UserRoles.vue'),
                }
            ]
        },
    ];

    moduleRoutes.forEach(function (route) {
        window.routes.push(route);
    });

    var moduleWidgets = [
        {
            name : 'user-count',
            component : require('./widgets/UserCount.vue'),
            permissions : ["USER_LISTINGS"],
            width : 1,
            height : 1,
            x : 0,
            y : 1
        }
    ];

    moduleWidgets.forEach(function (widget) {
        window.widgets.push(widget);
    });
})();
