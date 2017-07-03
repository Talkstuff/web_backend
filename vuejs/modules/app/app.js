window.routes = window.routes || [];

var appRoutes = [
    { path: '/modules', name : 'app.modules', component: require('./components/appModules/AppModules.vue') },
    { path: '/dashboard', name : 'app.dashboard', component: require('./components/Dashboard.vue') },

];

appRoutes.forEach(function (route) {
    window.routes.push(route);
});
