<template>
    <div class="uk-margin-remove-top" uk-grid>
        <div class="uk-width-1-1 uk-margin-remove">
            <div class="uk-card uk-card-default ">
                <div class="uk-card-header">
                    <div uk-grid>
                        <div class="uk-width-expand@m">
                            <h3 class="uk-card-title uk-margin-remove-bottom">
                                {{ $parent.user.username }}: <span class="uk-text-bold">Roles</span>
                            </h3>
                        </div>
                        <div class="uk-width-auto@m">

                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <div class="uk-form-controls uk-flex uk-flex-column">
                        <label v-for="role in roles">
                            <input class="uk-checkbox uk-text-middle"
                                   :value="role.id"
                                   :checked="exists(role.id)"
                                   type="checkbox" v-model="$parent.user.roleIds">
                            {{ role.description }}
                        </label>
                    </div>

                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary" @click="save()">Save</button>
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
                roles : []
            }
        },
        methods : {
            loadRoles : function(){
                var vm = this;

                vm.$http.get('/api/security/roles/fetch-roles', {
                    before: function(request){
                        this.$root.notify("Contacting server for security roles... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'roles',response.data);
                        },
                        function(error){

                            vm.$root.notify('Error loading roles...', 'error');
                        }
                )
            },
            exists : function(role){
                return _.contains(this.$parent.user.roles, role);
            },
            save : function () {
                var vm = this;

                vm.$http.post('/api/users/save-role', this.$parent.user,{
                    before : function(){
                        console.log(this.$parent.user);
                        vm.$root.notify('Update user roles: ' + this.$parent.user.firstName);
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$root.notify(this.$parent.user.firstName + ' has been saved successfully!', 'success');

                        },
                        function(error){
                            vm.$root.notify('Error: ' + error.data.message, 'error');
                        }
                );
            }
        },
        mounted : function () {
            this.loadRoles();

        }
    }
</script>
