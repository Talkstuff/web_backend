<template>
    <div>
        <div class="uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
            <div class="uk-width-1-1">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <router-link tag="a" :to="{name : 'security.roles'}" :class="'uk-button uk-button-secondary'">
                            <i class="fa fa-arrow-left"></i>
                            Back to list
                        </router-link>
                    </div>
                    <form @submit.prevent="save()">
                        <div class="uk-card-body">
                            <div class="uk-margin">
                                <label class="uk-form-label" for="role.name">Role Name:</label>
                                <div class="uk-form-controls">
                                    <input id="role.name" v-model="role.name" name="roleName"
                                           v-validate="'required|alpha_dash'"
                                           :class="{'uk-form-danger': errors.has('roleName') }"
                                           class="uk-input uk-form-width-expand" type="text"
                                           placeholder="Role name">
                                    <span class="uk-text-meta uk-text-danger" v-show="errors.has('roleName')">
                                                {{ errors.first('roleName') }}
                                        </span>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="role.description">Description:</label>
                                <div class="uk-form-controls">
                                    <input id="role.description" v-model="role.description" name="roleDescription"
                                           v-validate="'required'"
                                           :class="{'uk-form-danger': errors.has('roleDescription') }"
                                           class="uk-input uk-form-width-expand" type="text"
                                           placeholder="Role description">
                                    <span class="uk-text-meta uk-text-danger" v-show="errors.has('roleDescription')">
                                                {{ errors.first('roleDescription') }}
                                        </span>
                                </div>
                            </div>

                            <div class="uk-margin">
                                {{ role.permissions.length }} privilege(s) selected
                            </div>
                        </div>

                        <div class="uk-card-footer">
                            <button type="submit" :disabled="!role.permissions.length" class="uk-button uk-button-primary">save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="uk-width-1-1">
                <h3>Module permissions</h3>

                <div class="uk-child-width-1-3@m uk-grid-small" v-if="modules.length" uk-grid>

                    <div class="uk-card uk-card-small uk-card-default" v-for="module in modules"
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
        </div>
    </div>
</template>
<style>

</style>
<script type="text/babel">

    export default{
        data(){
            return{
                role : {
                    id : null,
                    name : '',
                    description : '',
                    permissions : []
                },
                modules : []
            }
        },
        methods : {
            getRole : function(){
                var vm = this;

                vm.$http.get('/api/security/roles/' + this.role.id + '/get',
                        {
                            before : function(request){
                                this.$root.notify("Fetching Role...");
                            }
                        }
                )
                        .then(
                                function(response){
                                    vm.$root.notify("Role found!",'success');

                                    Vue.set(vm,'role', response.data);
                                },
                                function(error){
                                    console.log(error);
                                }
                        );
            },
            save : function(){
                var vm = this;

                console.log(this.role);

                vm.$http.post('/api/security/roles/save', this.role,{
                    before : function(){
                        vm.$root.notify('Saving role: ' + vm.role.description);
                        // we only need the access key to be submitted to the server

                    }
                }).then(
                        function(response){
                            console.log(response.data);
                            vm.$root.notify(vm.role.description + ' has been saved successfully!', 'success');

                            window.router.back();

                        },
                        function(error){
                            vm.$root.notify('Error: ' + error.data.message, 'error');

                            console.log(error);
                        }
                );
            },
            validateBeforeSubmit: function() {
                this.$validator.validateAll().then(() => {
                    // eslint-disable-next-line
                    this.save();
                }).catch(() => {
                    // eslint-disable-next-line
                    UIkit.modal.alert('There are errors with your input. Please re-check!').then(function() {});
                });
            },
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
            togglePermission : function (permission) {

                var vm = this;
                var found = _.find(vm.role.permissions, function(item){
                    if(_.isEqual(item, permission.access)) return true;
                });

                if(found){
                    // remove permission from role
                    var removed = _.without(vm.role.permissions, found);
                    vm.$set(vm.role,'permissions', removed);
                } else {
                    // add permission to role
                    vm.role.permissions.push(permission.access);
                }
            },
            exists : function(access){
                return _.contains(this.role.permissions, access);
            }
        },
        mounted : function(){
            var vm = this;

            if(this.$route.params.roleId){
                this.role.id = this.$route.params.roleId;

                this.getRole();

                this.$set(this.$root,'pageTitle','Security: Edit Role');

            } else {
                this.$set(this.$root,'pageTitle','Security: New Role');
            }

            this.getModules();
        }
    }
</script>
