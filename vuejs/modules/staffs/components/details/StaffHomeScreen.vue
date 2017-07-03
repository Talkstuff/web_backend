<template>
    <div class="uk-margin-remove-top" uk-grid>
        <div class="uk-width-1-1 uk-margin-remove">
            <div class="uk-card uk-card-default ">
                <div class="uk-card-header">
                    <div uk-grid>
                        <div class="uk-width-expand@m">
                            <h3 class="uk-card-title uk-margin-remove-bottom">
                                {{ $parent.staff.firstName }}: <span class="uk-text-bold">Profile</span>
                            </h3>
                        </div>
                        <div class="uk-width-auto@m">
                            <div class="uk-margin-remove" v-if="$root.hasPermission('staff__activate')">
                                <button v-if="!$parent.staff.active"
                                        class="uk-button uk-width-1-1 uk-button-small uk-button-secondary"
                                        @click="toggleActivation()">
                                    activate
                                </button>
                                <button v-if="$parent.staff.active"
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
                                        <label class="uk-form-label">Name:</label> {{ $parent.staff.fullName }}
                                    </li>
                                    <li>
                                        <label class="uk-form-label">Username:</label> {{ $parent.staff.username }}
                                    </li>
                                    <li>
                                        <label class="uk-form-label">Phone:</label> {{ $parent.staff.phone }}
                                    </li>
                                    <li>
                                        <label class="uk-form-label">Email:</label> {{ $parent.staff.email }}
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
                                         :class="{'bg-darkGreen' : $parent.staff.active, 'bg-darkRed' : !$parent.staff.active}">
                                        <h3 class="uk-h3 uk-margin-remove uk-text-center fg-white">
                                            Account is <br>
                                            <span class="" v-if="$parent.staff.active">
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
        <div id="staff-modal" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Staff</h2>
                </div>
                <div class="uk-modal-body">

                </div>

                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    <button class="uk-button uk-button-primary uk-modal-close" type="button" @click="save()">Save</button>
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
            toggleActivation : function(){
                var vm = this;

                vm.$http.get('/api/staffs/' + vm.$parent.staff.id + '/toggle-activation',{
                    before : function(request){
                        vm.$root.notify('Contacting server.... Please wait!');
                    }
                }).then(
                    function(response){
                        vm.$root.notify('Staff Updated!','success');

                        bus.$emit('refresh-staff', response.data);
                    },
                    function(error){
                        console.log(error.data);
                    }
                )
            },
            confirmDelete : function(){
                var vm = this;

                UIkit.modal.confirm('Are you sure you want to proceed?').then(function() {

                    vm.$http.get('/api/staffs/' + vm.$parent.staff.id + '/delete').then(
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
        },
        mounted : function () {
            /*bus.$on('staff-found', function(){
            });*/
        }
    }
</script>
