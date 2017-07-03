window.routes = window.routes || [];

(function () {
    var moduleRoutes = [
        { path: '/security/permissions', name : 'security.permissions', component: require('./components/permissions/Permissions.vue') },

        { path: '/security/roles', name : 'security.roles', component: require('./components/roles/Roles.vue') },
        { path: '/security/roles/new', name : 'security.roles.new', component: require('./components/roles/NewRole.vue') },
        { path: '/security/roles/:roleId/edit', name : 'security.roles.edit', component: require('./components/roles/NewRole.vue') },

        { path: '/security/change-password', name : 'security.change_password', component: require('./components/ChangeLogin.vue') },
    ];

    moduleRoutes.forEach(function (route) {
        window.routes.push(route);
    });
})();


