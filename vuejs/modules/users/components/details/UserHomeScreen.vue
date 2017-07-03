<template>
    <div class="uk-margin-remove-top" uk-grid>
        <div class="uk-width-1-1 uk-margin-remove">
            <div class="uk-card uk-card-default ">
                <div class="uk-card-header">
                    <div uk-grid>
                        <div class="uk-width-expand@m">
                            <h3 class="uk-card-title uk-margin-remove-bottom">
                                {{ $parent.user.firstName }}: <span class="uk-text-bold">Profile</span>
                            </h3>
                        </div>
                        <div class="uk-width-auto@m">
                            <div class="uk-margin-remove" v-if="$root.hasPermission('user__activate')">
                                <button v-if="!$parent.user.active"
                                        class="uk-button uk-width-1-1 uk-button-small uk-button-secondary"
                                        @click="toggleActivation()">
                                    activate
                                </button>
                                <button v-if="$parent.user.active"
                                        class="uk-button uk-width-1-1 uk-button-small fg-white bg-darkRed bg-hover-amber"
                                        @click="toggleActivation()">
                                    de-activate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <div class="uk-grid-match uk-grid-small uk-grid-divider" uk-grid>
                        <div class="uk-width-1-3@m uk-card uk-card-small">
                            <div class="uk-card-body">
                                <ul class="uk-list">
                                    <li>
                                        <label class="uk-form-label">Name:</label> {{ $parent.user.fullName }}
                                    </li>
                                    <li>
                                        <label class="uk-form-label">Username:</label> {{ $parent.user.username }}
                                    </li>
                                    <li>
                                        <label class="uk-form-label">Phone:</label> {{ $parent.user.phone }}
                                    </li>
                                    <li>
                                        <label class="uk-form-label">Email:</label> {{ $parent.user.email }}
                                    </li>
                                </ul>
                            </div>
                            <div class="uk-card-footer" uk-margin>
                                <a class="uk-button uk-button-small uk-button-danger"
                                   uk-tooltip title="Delete" @click="confirmDelete(index)">
                                    <span class="fa fa-times"></span> Delete
                                </a>
                            </div>
                        </div>
                        <div class="uk-width-2-3@m uk-card uk-card-small">
                            <div class="uk-flex uk-flex-wrap uk-child-width-1-3@m uk-grid-small" uk-grid>
                                <div>
                                    <div class="uk-tile uk-padding-small"
                                         :class="{'bg-darkGreen' : $parent.user.active, 'bg-darkRed' : !$parent.user.active}">
                                        <h3 class="uk-h3 uk-margin-remove uk-text-center fg-white">
                                            Account is <br>
                                            <span class="" v-if="$parent.user.active">
                                            Active
                                            <br><i class="fa fa-check"></i>
                                        </span>
                                            <span class="" v-else>
                                                Pending Activation
                                                <br>
                                                <i class="fa fa-ban"></i>
                                            </span>
                                        </h3>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-width-1-1 uk-margin">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">User Groups</h3>
                </div>
                <div class="uk-card-body">
                    <div class="uk-form-controls uk-flex uk-flex-column">
                        <label v-for="group in groups">
                            <input class="uk-checkbox uk-text-middle"
                                   :value="group.id"
                                   :checked="exists(group.id)"
                                   type="checkbox" v-model="$parent.user.groupIds">
                            {{ group.name }}
                        </label>
                    </div>

                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary uk-button-small" @click="saveUserGroup()">Update User Groups</button>
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
                groups : [],
                user : {
                    id : null,
                    name : '',
                    username : '',
                    firstName : '',
                    lastName : '',
                    otherNames : '',
                    email : '',
                    phone : '',
                },
            }
        },
        methods : {
            userModal : function(user){
                if(user !== undefined){
                    Vue.set(this, 'user', user);
                } else {
                    Vue.set(this, 'user', {
                        id : null,
                        name : '',
                        username : '',
                        firstName : '',
                        lastName : '',
                        otherNames : '',
                        email : '',
                        phone : '',
                        branch_id : '',
                    })
                }
            },
            toggleActivation : function(){
                var vm = this;

                vm.$http.get('/api/users/' + vm.$parent.user.id + '/toggle-activation',{
                    before : function(request){
                        vm.$root.notify('Contacting server.... Please wait!');
                    }
                }).then(
                    function(response){
                        vm.$root.notify('Staff Updated!','success');

                        bus.$emit('refresh-user', response.data);
                    },
                    function(error){
                        console.log(error.data);
                    }
                )
            },
            confirmDelete : function(){
                var vm = this;

                UIkit.modal.confirm('Are you sure you want to proceed?').then(function() {

                    vm.$http.get('/api/users/' + vm.$parent.user.id + '/delete').then(
                            function(response){
                                vm.$root.notify(response.data.firstName + ' has been successfully deleted from the system.');
                                vm.$root.back();
                            },
                            function(error){
                                console.log(error);
                            }
                    );

                }, function () {
                    //console.log('Rejected.')
                });

            },
            exists : function(groupId){
                return _.contains(this.$parent.user.groupIds, groupId);
            },
            loadGroups : function(){
                var vm = this;

                vm.$http.get('/api/users/groups', {
                    before: function(request){
                        this.$root.notify("Contacting server for user groups... Please wait.");
                    }
                }).then(
                        function(response){
                            vm.$set(vm,'groups',response.data);
                        },
                        function(error){

                            vm.$root.notify('Error loading roles...', 'error');
                        }
                )
            },
            saveUserGroup : function () {
                var vm = this;

                vm.$http.post('/api/users/save-group', this.$parent.user,{
                    before : function(){
                        console.log(this.$parent.user);
                        vm.$root.notify('Updating user group: ' + this.$parent.user.firstName);
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$root.notify(this.$parent.user.firstName + ' has been updated successfully!', 'success');

                        },
                        function(error){
                            vm.$root.notify('Error: ' + error.data.message, 'error');
                        }
                );
            }
        },
        mounted : function () {
            /*bus.$on('user-found', function(){
            });*/
            this.loadGroups();
        }
    }
</script>
