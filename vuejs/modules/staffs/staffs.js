window.routes = window.routes || [];
window.widgets = window.widgets || [];

(function () {
    var moduleRoutes = [
        { path: '/staffs', name : 'staffs', component: require('./components/Staffs.vue') },
        { path: '/staffs/new', name : 'staffs.new', component: require('./components/NewStaff.vue') },

        { path: '/staffs/:staffId/details',
            name: 'staffs.details',
            component: require('./components/Details.vue'),
            beforeEnter: function (to, from, next) {
                next(function (vm) {
                    if(!vm.$root.hasPermission('STAFF_MANAGE_DETAILS')){
                        return false;
                    }
                    return true;
                });
            },
            children: [
                {
                    path: 'home',
                    name: 'staffs.details.home',
                    component: require('./components/details/StaffHomeScreen.vue'),
                },
                {
                    path: 'edit',
                    name: 'staffs.details.edit',
                    component: require('./components/NewStaff.vue'),
                },
                {
                    path: 'permissions',
                    name: 'staffs.details.permissions',
                    component: require('./components/details/StaffRoles.vue'),
                }
            ]
        },
    ];

    moduleRoutes.forEach(function (route) {
        window.routes.push(route);
    });

    var moduleWidgets = [
        {
            name : 'staff-count',
            component : require('./widgets/StaffCount.vue'),
            permissions : ["STAFF_LISTINGS"],
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
