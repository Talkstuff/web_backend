<template>
    <div class="">
        <div class="uk-width-1-1">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">
                            <router-link :to="{name : 'staffs.new'}" class="uk-button uk-button-primary"
                            v-if="$root.hasPermission('staff__add')">
                                <i class="fa fa-plus-circle"></i>
                                New Staff
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <table class="uk-table" v-if="staffs.length">
                        <caption>You have {{ staffs.length }} staff(s).</caption>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(staff, index) in staffs" :key="staff.id" >
                            <td>{{index + 1}}</td>
                            <td>{{ staff.fullName }}</td>
                            <td class="uk-text-right">
                                <router-link :to="{name : 'staffs.details.home', params : {staffId : staff.id}}"
                                        class="uk-button uk-button-default uk-border-rounded bg-ts fg-white
                                bg-hover-white fg-hover-red">Manage</router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div v-else class="uk-card uk-card-body uk-padding-large uk-flex uk-flex-center">
                        <h3 class="uk-h2 uk-text-center uk-text-muted" v-if="$root.loadingData">
                            <div uk-spinner></div>
                        </h3>
                        <h3 class="uk-h3 uk-text-center uk-text-muted" v-else>No data returned!</h3>
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
                staffs : [],
                branches : [],
                staff : {
                    id : null,
                    name : '',
                    username : '',
                    firstName : '',
                    lastName : '',
                    otherNames : '',
                    email : '',
                    phone : '',
                    branch_id : '',
                },
                usernameExists : false,
                emailExists : false
            }
        },
        methods : {
            staffModal : function(staff){
                if(staff !== undefined){
                    Vue.set(this, 'staff', staff);
                } else {
                    Vue.set(this, 'staff', {
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
            loadStaffs : function(){
                var vm = this;

                vm.$http.get('/api/staffs/', {
                    before: function(request){
                        vm.$set(vm.$root,'loadingData',true);

                        this.$root.notify("Contacting server for Staffs... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'staffs',response.data);
                            vm.$set(vm.$root,'loadingData',false);

                            this.$root.notify(vm.staffs.length + " staff(s) found.", 'success');
                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading staffs...', 'error');
                        }
                )
            },
            save : function(){
                var vm = this;

                vm.$http.post('/api/staffs/save', this.staff,{
                    before : function(){
                        vm.$root.notify('Creating staff: ' + vm.staff.firstName);
                    }
                }).then(
                        function(response){
                            if(!vm.staff.id){ // we are creating a new staff, so we push into the array
                                vm.staffs.push(response.data);
                            }

                            vm.$root.notify('Saved! ' + vm.staff.name, 'success');

                        },
                        function(error){

                        }
                );
            },
            confirmDelete : function(staffIndex){
                var vm = this;

                var delStaff = vm.staffs[staffIndex];

                UIkit.modal.confirm('Are you sure you want to proceed?').then(function() {

                    vm.staffs.splice(staffIndex, 1);

                    vm.$http.get('/api/staffs/' + delStaff.id + '/delete').then(
                            function(response){
                                vm.$root.notify(response.data.name + ' has been successfully deleted from the system.');
                            },
                            function(error){
                                console.log(error);
                            }
                    );

                }, function () {
                    //console.log('Rejected.')
                });

            },
            validateUsernameOnServer : function(){
                var vm = this;

                if(vm.staff.username.length){
                    vm.$http.get('/api/security/users/' + vm.staff.username + '/search-username',{
                        before : function(request){
                            request.params.searching = true;
                        }
                    })
                            .then(
                                    function(response){
                                        // server should return with a member with this username
                                        var user = response.data;

                                        if(user.id != undefined){
                                            vm.$set(vm,'userExists',true);
                                            vm.$validator.errorBag.add('username','Username has been taken');

                                        } else {
                                            vm.$set(vm,'userExists', false);
                                        }

                                    },
                                    function(error){
                                        // error occurred
                                    }
                            );
                }
            },
            validateEmailOnServer : function(){
                var vm = this;

                if(vm.staff.email.length){
                    vm.$http.get('/api/security/users/' + vm.staff.email + '/search-email',{
                        before : function(request){
                            request.params.searching = true;
                        }
                    })
                            .then(
                                    function(response){
                                        // server should return with a member with this username
                                        var user = response.data;

                                        if(user.id != undefined){
                                            vm.$set(vm,'emailExists',true);
                                            vm.$validator.errorBag.add('email','Email address already exists');
                                        } else {
                                            vm.$set(vm,'emailExists', false);
                                        }

                                    },
                                    function(error){
                                        // error occurred
                                    }
                            );
                }
            }
        },
        beforeCreate : function(){
            Vue.set(this.$root,'pageTitle','Staffs');
        },
        mounted : function(){
            this.loadStaffs();
        }
    }
</script>

