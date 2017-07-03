<template>
    <div>
        <div class="uk-flex-middle uk-flex" uk-grid>
            <div class="uk-width-auto@m">
                <router-link tag="button" :to="{name : 'users'}" :class="'uk-button uk-button-secondary'">
                    <i class="fa fa-arrow-left"></i>
                    Back to list
                </router-link>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-flex uk-flex-right uk-grid-small uk-child-width-1-5@m uk-flex-middle uk-grid-match" uk-grid>
                    <div>
                        <router-link :to="{name : 'users.details.home', params : {userId : user.id}}"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-ts uk-card-body uk-text-center"
                            :class="{'bg-ts uk-dark fg-white bg-hover-white fg-hover-white' : $route.name == 'users.details.home',
                            'uk-dark fg-ts fg-hover-white bg-white' : $route.name != 'users.details.home'}">
                                <span uk-icon="ratio: 2; icon: home"></span> <br>
                                Summary
                            </div>
                        </router-link>
                    </div>
                    <div>
                        <router-link :to="{name : 'users.details.roles', params : {userId : user.id}}"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-ts uk-card-body uk-text-center"
                                 :class="{'bg-ts uk-dark fg-white bg-hover-white fg-hover-white' :
                                 $route.name == 'users.details.roles',
                                 'uk-dark fg-ts fg-hover-white bg-white' : $route.name != 'users.details.roles'}">
                                <span uk-icon="ratio: 2; icon: lock"></span> <br>
                                Roles
                            </div>
                        </router-link>
                    </div>
                    <div>
                        <router-link :to="{name : 'users.details.edit', params : {userId : user.id}}"
                                     v-if="$root.hasPermission('STAFF__EDIT')"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-cyan uk-card-body uk-text-center"
                                 :class="{'bg-white uk-dark fg-cyan fg-hover-white' : $route.name == 'users.details.edit', 'uk-light bg-darkGray' : $route.name != 'users.details.edit'}">
                                <span uk-icon="ratio: 2; icon: pencil"></span> <br>
                                Edit
                            </div>
                        </router-link>
                    </div>
                    <div>
                        <router-link :to="{name : 'users.details.permissions', params : {userId : user.id}}"
                                     v-if="$root.hasPermission('user__grant_custom_access')"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-cyan uk-card-body uk-text-center"
                                 :class="{'bg-white uk-dark fg-cyan fg-hover-white' :
                                 $route.name == 'users.details.permissions',
                                 'uk-light bg-darkGray' : $route.name != 'users.details.permissions'}">
                                <span uk-icon="ratio: 2; icon: lock"></span> <br>
                                User Permissions
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>
<style>
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                user : {
                    id :null,
                    permissions : []
                }
            }
        },
        methods : {
            getUser : function(){
                var vm = this;

                vm.$http.get('/api/users/' + this.user.id + '/',
                        {
                            before : function(request){
                                //console.log(vm.$data);
                                this.$root.notify("Fetching User...");
                            }
                        }
                )
                        .then(
                                function(response){
                                    vm.$root.notify("User found!",'success');

                                    Vue.set(vm,'user', response.data);

                                    bus.$emit('user-found',response.data);
                                },
                                function(error){
                                    console.log(error);
                                }
                        );
            },
        },
        created : function(){
            if(this.$route.params.userId){
                this.user.id = this.$route.params.userId;

                this.getUser();
            }
        },
        mounted : function(){
            var vm = this;

            bus.$on('user-found', function(user){
                Vue.set(vm.$root,'pageTitle','User: ' + vm.user.fullName);
            });

            bus.$on('user-updated', function(user){
                vm.$set(vm,'user', user);
                Vue.set(vm.$root,'pageTitle','User: ' + vm.user.fullName);

            });

            bus.$on('refresh-user', function(user){
                vm.getUser();
            });
        }
    }
</script>
