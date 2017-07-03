<template>
    <div>
        <div class="uk-width-1-1">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title">Permissions</h3>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <table class="uk-table uk-table-hover uk-table-divider uk-table-striped" v-if="permissions.length">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(permission, index) in permissions">
                            <td>{{ index + 1 }}</td>
                            <td>{{ permission.name }}</td>
                            <td class="uk-position-relative" uk-toggle="target: > span.controls; mode: hover; cls: uk-hidden">
                                {{ permission.description }}
                                <span class="controls uk-position-right bg-white uk-hidden uk-flex
                                    uk-flex-middle uk-flex-center" uk-margin>
                                        <a href="javascript:void(0)"
                                           uk-toggle="target: #new-category-permission-modal"
                                           @click.prevent="editPermission(permission)"
                                           class="uk-icon-link uk-margin-small-right fg-cyan"
                                           uk-icon="icon: pencil"></a>

                                        <a href="javascript:void(0)"
                                           class="uk-icon-link fg-ts"
                                           @click.prevent="delPermission(permission)"
                                           uk-icon="icon: trash"></a>
                                    </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div v-else class="uk-card uk-card-body uk-padding-large uk-flex uk-flex-center">
                        <h3 class="uk-h2 uk-text-center uk-text-muted" v-if="$root.loadingData">
                            <div uk-spinner></div>
                        </h3>
                        <h3 class="uk-h3 uk-text-center uk-text-muted" v-else>No records found...</h3>
                    </div>

                </div>
                <div class="uk-card-footer">
                    <button class="uk-button uk-button-primary"
                            @click="newPermission()"
                            uk-toggle="target: #new-category-permission-modal">
                        new permission
                    </button>
                </div>
            </div>
        </div>

        <div id="new-category-permission-modal" uk-modal="center: true">
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <div class="uk-modal-header bg-ts">
                    <h2 class="uk-modal-title fg-white">Add Permission</h2>
                </div>
                <div class="uk-modal-body">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="permission.name">Permission</label>
                        <div class="uk-form-controls">
                            <input id="permission.name" v-model="permission.name" name="permissionName"
                                   class="uk-input uk-form-width-expand" type="text"
                                   placeholder="Enter a suitable name of permission">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="permission.description">Description:</label>
                        <div class="uk-form-controls">
                            <input id="permission.description" v-model="permission.description" name="permissionDescription"
                                   class="uk-input uk-form-width-expand" type="text"
                                   placeholder="Briefly describe this permission....">
                        </div>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    <button class="uk-button uk-button-primary uk-modal-close" type="button"
                            @click="savePermission()">Submit</button>
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
                permissions : [],

                permission : {
                    id : null,
                    name: '',
                    description: ''
                }
            }
        },
        methods : {
            loadPermissions : function(){
                var vm = this;

                vm.$http.get('/api/security/permissions/fetch-permissions', {
                    before: function(request){
                        vm.$set(vm.$root,'loadingData',true);

                        this.$root.notify("Contacting server for security permissions... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'permissions',response.data);
                            vm.$set(vm.$root,'loadingData',false);

                            this.$root.notify(vm.permissions.length + " permission(s) found.", 'success');
                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading permissions...', 'error');
                        }
                )
            },
            delPermission : function (permission) {
                var vm = this;

                var index = this.permissions.findIndex(function (perm) {
                    return permission.id === perm.id;
                });

                UIkit.modal.confirm('Are you sure you want to proceed?').then(function() {

                    vm.permissions.splice(index, 1);

                    vm.$http.get('/api/security/permissions/' + permission.id + '/delete-permission').then(
                            function(response){
                                vm.$root.notify('Successfully deleted from the system.');
                            },
                            function(error){
                                console.log(error);
                            }
                    );

                }, function () {
                    //console.log('Rejected.')
                });
            },

            savePermission : function () {
                var vm = this;

                vm.$http.post('/api/security/permissions', this.permission,{
                    before : function(){
                        vm.$root.notify('Saving permission: ' + vm.permission.name);
                    }
                }).then(
                        function(response){
                            if(!vm.permission.id){ // we are creating a new branch, so we push into the array
                                vm.permissions.push(response.data);
                            }
                            vm.$root.notify('Permission saved!', 'success');
                        },
                        function(error){}
                );
            },

            editPermission: function(permission){
                this.permission = permission;
            },
            newPermission: function(){
                this.permission = {
                    id: null,
                    name: ''
                };
            },

        },
        mounted : function(){
            this.$set(this.$root,'pageTitle','Security: Permissions');

            this.loadPermissions();
        }
    }
</script>
