<template>
    <div>
        <div class="uk-width-1-1">
            <div class="uk-card uk-card-default" >
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title">Roles</h3>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <table class="uk-table uk-table-hover uk-table-divider uk-table-striped" v-if="roles.length">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(role, index) in roles"
                            uk-toggle="target: > td > span.controls; mode: hover; cls: uk-hidden">
                            <td>{{ index + 1 }}</td>
                            <td>{{ role.name }}</td>
                            <td class="uk-position-relative">
                                {{ role.description }}
                                <span class="controls uk-position-right bg-white uk-hidden uk-flex
                                    uk-flex-middle uk-flex-center" uk-margin>
                                        <a href="javascript:void(0)"
                                           uk-toggle="target: #new-category-role-modal"
                                           @click.prevent="editRole(role)"
                                           class="uk-icon-link uk-margin-small fg-cyan"
                                           uk-icon="icon: pencil"></a>

                                        <a href="javascript:void(0)"
                                           class="uk-icon-link uk-margin-small fg-magenta"
                                           uk-icon="icon: user"></a>

                                        <a href="javascript:void(0)"
                                           class="uk-icon-link fg-ts uk-margin-small"
                                           @click.prevent="delRole(role)"
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
                            @click="newRole()"
                            uk-toggle="target: #new-category-role-modal">
                        new role
                    </button>
                </div>
            </div>
        </div>

        <div id="new-category-role-modal" uk-modal="center: true">
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <div class="uk-modal-header bg-ts">
                    <h2 class="uk-modal-title fg-white">Add Role</h2>
                </div>
                <div class="uk-modal-body">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="role.name">Role</label>
                        <div class="uk-form-controls">
                            <input id="role.name" v-model="role.name" name="roleName"
                                   class="uk-input uk-form-width-expand" type="text"
                                   placeholder="Enter a suitable name of role">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="role.description">Description:</label>
                        <div class="uk-form-controls">
                            <input id="role.description" v-model="role.description" name="roleDescription"
                                   class="uk-input uk-form-width-expand" type="text"
                                   placeholder="Briefly describe this role....">
                        </div>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    <button class="uk-button uk-button-primary uk-modal-close" type="button"
                            @click="saveRole()">Submit</button>
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
                roles : [],
                role : {
                    id : null,
                    name: '',
                    description: ''
                }
            }
        },
        methods : {
            loadRoles : function(){
                var vm = this;

                vm.$http.get('/api/security/roles/fetch-roles', {
                    before: function(request){
                        vm.$set(vm.$root,'loadingData',true);

                        this.$root.notify("Contacting server for security roles... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'roles',response.data);
                            vm.$set(vm.$root,'loadingData',false);

                            this.$root.notify(vm.roles.length + " role(s) found.", 'success');
                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading roles...', 'error');
                        }
                )
            },

            delRole : function (role) {
                var vm = this;

                var index = this.roles.findIndex(function (perm) {
                    return role.id === perm.id;
                });

                UIkit.modal.confirm('Are you sure you want to proceed?').then(function() {

                    vm.roles.splice(index, 1);

                    vm.$http.get('/api/security/roles/' + role.id + '/delete').then(
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

            saveRole : function () {
                var vm = this;

                vm.$http.post('/api/security/roles/save', this.role,{
                    before : function(){
                        vm.$root.notify('Saving role: ' + vm.role.name);
                    }
                }).then(
                        function(response){
                            if(!vm.role.id){ // we are creating a new branch, so we push into the array
                                vm.roles.push(response.data);
                            }
                            vm.$root.notify('Role saved!', 'success');
                        },
                        function(error){}
                );
            },

            editRole: function(role){
                this.role = role;
            },
            newRole: function(){
                this.role = {
                    id: null,
                    name: ''
                };
            },
        },
        mounted : function(){
            this.$set(this.$root,'pageTitle','Security: Roles');

            this.loadRoles();
        }
    }
</script>
