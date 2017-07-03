<template>
    <div class="gridster uk-grid-small uk-child-width-auto@m uk-width-1-1" uk-grid>
        <h3>Dashboard widgets...</h3>
    </div>
</template>
<style>
</style>
<script type="text/babel">
    //require('../../../../public/vendors/gridster/jquery.gridster.min.js');
    export default{
        data(){
            return{
                loadedWidgets : [],
                currentColumn : 1,
                currentRow : 1,
            }
        },
        methods : {
            loadWidgets : function () {
                var vm = this;
                window.widgets.forEach(function (widget) {
                    var widgetPermissions = widget.permissions;

                    if(widgetPermissions && widgetPermissions.length){

                        var addWidget = _.find(widgetPermissions,function (permission) {
                            if(_.contains(vm.$root.system.user.privileges, permission)){
                                return true;
                            }
                        });

                        if(addWidget) vm.loadedWidgets.push(widget);
                    }
                });


                vm.initDashboard();
            },
            initDashboard : function () {
                setTimeout(function () {
                    window.dashboardGrid = new Gridster(
                            $('.gridster'),
                            {
                                widget_base_dimensions: ['auto', 180],
                                autogenerate_stylesheet: true,
                                min_cols: 1,
                                max_cols: 3,
                                avoid_overlapped_widgets: true,
                                resize: {
                                    enabled: false
                                },
                                widget_margins: [15, 10],
                                widget_selector: "div.widget",
                            }
                    )
                },1000);
            }
        },
        mounted : function(){
            this.$set(this.$root,'pageTitle','Dashboard');

            var vm = this;

            if(this.$root.system.user){
                //vm.loadWidgets();

            }

            bus.$on('app-loaded', function (system) {
                //console.log('app loaded');
                //vm.loadWidgets();

            });

        }
    }
</script>
