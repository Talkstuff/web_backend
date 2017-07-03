<template>
    <div class="uk-margin-remove-top" uk-grid>
        <div class="uk-width-1-1 uk-margin-remove">
            <div class="uk-card uk-card-default ">
                <div class="uk-card-header">
                    <div uk-grid>
                        <div class="uk-width-expand@m">
                            <h3 class="uk-card-title uk-margin-remove-bottom">
                                {{ $parent.staff.firstName }}: <span class="uk-text-bold">Custom Privileges</span>
                            </h3>
                        </div>
                        <div class="uk-width-auto@m">

                        </div>
                    </div>
                </div>
                <form @submit.prevent="saveStaffRole()">
                    <div class="uk-card-body">
                        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-divider" v-if="modules.length" uk-grid>

                            <div class="uk-card uk-card-small" v-for="module in modules"
                                 v-if="module.permissions.length">
                                <div class="uk-card-header">
                                    <h3 class="uk-card-title uk-margin-remove-bottom">{{module.name}}</h3>
                                    <p class="uk-margin-remove-top">{{ module.description }}</p>
                                </div>
                                <div class="uk-card-body">
                                    <div class="uk-margin uk-grid-small uk-child-width-1-1 uk-flex uk-flex-column">
                                        <label v-for="permission in module.permissions">
                                            <input class="uk-checkbox permissions" type="checkbox"
                                                   :checked="exists(permission.access)"
                                                   v-on:change="togglePermission(permission)">
                                            {{ permission.description }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-footer">
                        <button type="submit" :disabled="$parent.staff.id && !$parent.staff.permissions.length"
                                class="uk-button uk-button-primary">save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
<style>
</style>
<script type="text/babel">

    export default{
        data(){
            return{
                modules : []
            }
        },
        methods : {
            getModules : function(){
                var vm = this;
                vm.$http.get('/api/app/modules',
                        {
                            before : function(request){
                                //this.$root.notify("Fetching Role...");
                            }
                        }
                )
                        .then(
                                function(response){
                                    //vm.$root.notify("Role found!",'success');

                                    Vue.set(vm,'modules', response.data);
                                },
                                function(error){
                                    console.log(error);
                                }
                        );
            },
            saveStaffRole : function(){
                var vm = this;

                vm.$http.post('/api/staffs/save-permissions', this.$parent.staff ,{
                    before : function(){
                        vm.$root.notify('Saving staff permissions');
                        // we only need the access key to be submitted to the server
                    }
                }).then(
                        function(response){
                            vm.$set(vm.$parent,'staff',response.data)
                            vm.$root.notify('Saved successfully!', 'success');

                            //window.router.back();

                        },
                        function(error){
                            vm.$root.notify('Error: ' + error.data.message, 'error');

                            console.log(error);
                        }
                );
            },
            togglePermission : function (permission) {
                var vm = this;
                var found = _.find(vm.$parent.staff.permissions, function(item){
                    if(_.isEqual(item, permission.access)) return true;
                });

                if(found){
                    // remove permission from role
                    var removed = _.without(vm.$parent.staff.permissions, found);
                    vm.$set(vm.role,'permissions', removed);
                } else {
                    // add permission to role
                    vm.$parent.staff.permissions.push(permission.access);
                }
            },
            exists : function(access){
                return _.contains(this.$parent.staff.permissions, access);
            }
        },
        mounted : function () {
            this.getModules();

        }
    }
</script>
