\y<template>
    <div>
        <div class="uk-width-1-1">
            <div class="uk-card uk-card-default uk-box-shadow-large">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">Staff Registration Form</h3>
                            <p class="uk-margin-remove-top">{{ staffName }}</p>
                        </div>
                        <div class="uk-width-auto">
                            <router-link tag="button" :to="{name : 'staffs'}"
                                         :class="'uk-button uk-button-secondary'">
                                <i class="fa fa-arrow-left"></i>
                                Back to list
                            </router-link>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="validateBeforeSubmit">
                    <div class="uk-card-body">
                        <div class="uk-grid-divider uk-grid-match" uk-grid>
                            <div class="uk-width-2-3@m">
                                <div class="uk-child-width-1-3@m uk-grid-small" uk-grid>
                                    <div class="">
                                        <label class="uk-form-label" for="staff.firstName">First Name:</label>
                                        <div class="uk-form-controls">
                                            <input id="staff.firstName" v-model="staff.firstName" autofocus
                                                   class="uk-input uk-form-width-expand" type="text" name="firstName"
                                                   v-validate="'required'"
                                                   :class="{'uk-form-danger': errors.has('firstName') }"
                                                   placeholder="Your first name...">
                                            <span class="uk-text-meta uk-text-danger" v-show="errors.has('firstName')">
                                                {{ errors.first('firstName') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="">
                                        <label class="uk-form-label" for="staff.otherNames">Other Names:</label>
                                        <div class="uk-form-controls">
                                            <input id="staff.otherNames" v-model="staff.otherNames"
                                                   class="uk-input uk-form-width-expand" type="text"
                                                   placeholder="Your other names...">
                                        </div>
                                    </div>

                                    <div class="">
                                        <label class="uk-form-label" for="staff.lastName">Last Name:</label>
                                        <div class="uk-form-controls">
                                            <input id="staff.lastName" v-model="staff.lastName" name="lastName"
                                                   v-validate="'required'"
                                                   :class="{'uk-form-danger': errors.has('lastName') }"
                                                   class="uk-input uk-form-width-expand" type="text"
                                                   placeholder="Your last name...">
                                            <span class="uk-text-meta uk-text-danger" v-show="errors.has('lastName')">
                                                {{ errors.first('lastName') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="uk-divider-icon" />

                                <div class="uk-child-width-1-2@m" uk-grid>
                                    <div class="uk-width-1-1">
                                        <label class="uk-form-label" for="staff.address">Address:</label>
                                        <div class="uk-form-controls">
                                            <textarea class="uk-textarea" id="staff.address" rows="3"
                                                      name="address" v-validate="'required'"
                                                      :class="{'uk-form-danger': errors.has('address') }"
                                                      v-model="staff.address"></textarea>
                                            <span class="uk-text-meta uk-text-danger" v-show="errors.has('address')">
                                                {{ errors.first('address') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label class="uk-form-label" for="staff.phone">Mobile Phone:</label>
                                        <div class="uk-form-controls">
                                            <input id="staff.phone" v-model="staff.phone" name="phone"
                                                   v-validate="'required|numeric|min:11'"
                                                   :class="{'uk-form-danger': errors.has('phone') }"
                                                   class="uk-input uk-form-width-expand" type="text"
                                                   placeholder="Your phone number...">
                                            <span class="uk-text-meta uk-text-danger" v-show="errors.has('phone')">
                                                {{ errors.first('phone') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label class="uk-form-label">:</label>
                                        <div class="uk-form-controls uk-flex uk-flex-column">
                                            <label>
                                                <input class="uk-checkbox"
                                                       type="checkbox" v-model="staff.active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-3@m">

                                <div class="uk-margin" v-if="branches.length">
                                    <label class="uk-form-label" for="staff.branch_id">Opening Branch:</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" id="staff.branch_id" v-model="staff.branch_id"
                                                name="branch"
                                                v-validate="'required'"
                                                :class="{'uk-form-danger': errors.has('branch') }"
                                        >
                                            <option v-for="branch in branches" :value="branch.id">
                                                {{ branch.name }}
                                            </option>
                                        </select>
                                        <span class="uk-text-meta uk-text-danger" v-show="errors.has('branch')">
                                        {{ errors.first('branch') }}
                                    </span>
                                    </div>
                                </div>

                                <div class="uk-margin" v-if="roles.length">
                                    <label class="uk-form-label">Roles:</label>
                                    <div class="uk-form-controls uk-flex uk-flex-column">
                                        <label v-for="role in roles" v-if="role.description != 'Member'">
                                            <input class="uk-checkbox"
                                                   :value="role.id"
                                                   :checked="exists(role.id)"
                                                   type="checkbox" v-model="staff.roleIds">
                                            {{ role.description }}
                                        </label>
                                    </div>
                                </div>

                                <div class="uk-margin" v-if="!staff.id">
                                    <label class="uk-form-label" for="staff.username">Your username:</label>
                                    <div class="uk-form-controls">
                                        <input id="staff.username" v-model="staff.username" name="username"
                                               class="uk-input uk-form-width-expand" type="text"
                                               v-validate="'required'"
                                               :class="{'uk-form-danger': errors.has('username')|| usernameExists }"
                                               v-on:blur="validateUsernameOnServer()"
                                               placeholder="Your username...">
                                        <span class="uk-text-meta uk-text-danger" v-show="errors.has('username')">
                                                {{ errors.first('username') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label" for="staff.email">Your Email:</label>
                                    <div class="uk-form-controls">
                                        <input id="staff.email" v-model="staff.email" name="email"
                                               v-validate="'required|email'"
                                               :class="{'uk-form-danger': errors.has('email') }"
                                               class="uk-input uk-form-width-expand" type="text"
                                               placeholder="Your email...">
                                        <span class="uk-text-meta uk-text-danger" v-show="errors.has('email')">
                                                {{ errors.first('email') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-footer">
                        <button type="submit" class="uk-button uk-button-primary">save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    export default{
        data(){
            return{
                branches : [],
                roles : [],
                staff : {
                    id : null,
                    branch_id : null,
                    roleIds : [],
                    permissions : [],
                    registrationDate : null,
                    username : '',
                    firstName : '',
                    lastName : '',
                    otherNames : '',
                    active : false,
                    email : '',
                    phone : '',
                },
                usernameExists : false,
                emailExists : false
            }
        },
        methods : {
            exists : function(roleId){
                return _.contains(this.staff.roleIds, roleId);
            },
            loadRoles : function(){
                var vm = this;

                vm.$http.get('/api/security/roles/', {
                    before: function(request){
                        this.$root.notify("Contacting server for security roles... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'roles',response.data);
                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading roles...', 'error');
                        }
                )
            },
            loadBranches : function(){
                var vm = this;

                vm.$http.get('/api/branches/').then(
                        function(response){
                            vm.$set(vm,'branches',response.data);

                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading branches...', 'error');
                        }
                )
            },
            save : function(){
                var vm = this;

                vm.$http.post('/api/staffs/save', this.staff,{
                    before : function(){
                        console.log(vm.staff);
                        vm.$root.notify('Saving staff: ' + vm.staff.firstName);
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$root.notify(vm.staff.firstName + ' has been saved successfully!', 'success');


                            if(vm.staff.id){ // we updated the staff
                             //   bus.$emit('staff-updated', response.data);
                            }

                            window.router.go(-1);

                        },
                        function(error){
                            vm.$root.notify('Error: ' + error.data.message, 'error');

                            console.log(error);
                        }
                );
            },
            getStaff : function(){
                var vm = this;

                if(vm.$parent.staff) vm.$set(vm,'staff', vm.$parent.staff);

            },
            validateBeforeSubmit: function() {
                this.$validator.validateAll().then(() => {
                    // eslint-disable-next-line
                    if(!this.usernameExists && !this.emailExists){
                        this.save();
                    } else {
                        UIkit.modal.alert('Username and/or email address already exists').then(function() {

                        });
                    }
                }).catch(() => {
                    // eslint-disable-next-line
                    UIkit.modal.alert('There are errors with your registration. Please re-check!').then(function() {

                    });
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
                                        // server should return with a staff with this username
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
        },
        beforeCreate : function(){

        },
        computed : {
            staffName : function(){
                return this.staff.firstName + ' ' + this.staff.otherNames + ' ' + this.staff.lastName;
            }
        },
        mounted : function(){
            if(this.$route.params.staffId){
                this.staff.id = this.$route.params.staffId;

                this.getStaff();
            } else {
                Vue.set(this.$root,'pageTitle','New Staff');
            }
            var vm = this;

            this.loadBranches();
            this.loadRoles();

            bus.$on('staff-found', function (staff) {
                vm.getStaff();
            })
        },
        created : function(){
            var vm = this;
            this.$watch('staffName', function(newVal, oldVal){
                if(newVal){
                    vm.heading = 'Staff: ' + newVal;
                } else {
                    vm.heading = 'New Staff';
                }
            });



        }
    }
</script>
