<template>
    <div>
        <div class="uk-flex-middle uk-flex" uk-grid>
            <div class="uk-width-auto@m">
                <router-link tag="button" :to="{name : 'staffs'}" :class="'uk-button uk-button-secondary'">
                    <i class="fa fa-arrow-left"></i>
                    Back to list
                </router-link>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-flex uk-flex-right uk-grid-small uk-child-width-1-5@m uk-flex-middle uk-grid-match" uk-grid>
                    <div>
                        <router-link :to="{name : 'staffs.details.home', params : {staffId : staff.id}}"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-ts uk-card-body uk-text-center"
                            :class="{'bg-white uk-dark fg-ts fg-hover-white' : $route.name == 'staffs.details.home',
                            'uk-light bg-darkGray' : $route.name != 'staffs.details.home'}">
                                <span uk-icon="ratio: 2; icon: home"></span> <br>
                                Summary
                            </div>
                        </router-link>
                    </div>
                    <div>
                        <router-link :to="{name : 'staffs.details.edit', params : {staffId : staff.id}}"
                                     v-if="$root.hasPermission('STAFF__EDIT')"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-cyan uk-card-body uk-text-center"
                                 :class="{'bg-white uk-dark fg-cyan fg-hover-white' : $route.name == 'staffs.details.edit', 'uk-light bg-darkGray' : $route.name != 'staffs.details.edit'}">
                                <span uk-icon="ratio: 2; icon: pencil"></span> <br>
                                Edit
                            </div>
                        </router-link>
                    </div>
                    <div>
                        <router-link :to="{name : 'staffs.details.permissions', params : {staffId : staff.id}}"
                                     v-if="$root.hasPermission('staff__grant_custom_access')"
                                     class="uk-link-reset">
                            <div class="uk-card uk-card-small bg-hover-cyan uk-card-body uk-text-center"
                                 :class="{'bg-white uk-dark fg-cyan fg-hover-white' :
                                 $route.name == 'staffs.details.permissions',
                                 'uk-light bg-darkGray' : $route.name != 'staffs.details.permissions'}">
                                <span uk-icon="ratio: 2; icon: lock"></span> <br>
                                Access Privileges
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
                staff : {
                    id :null,
                    permissions : []
                }
            }
        },
        methods : {
            getStaff : function(){
                var vm = this;

                vm.$http.get('/api/staffs/' + this.staff.id + '/get',
                        {
                            before : function(request){
                                //console.log(vm.$data);
                                this.$root.notify("Fetching Staff...");
                            }
                        }
                )
                        .then(
                                function(response){
                                    vm.$root.notify("Staff found!",'success');

                                    Vue.set(vm,'staff', response.data);

                                    bus.$emit('staff-found',response.data);
                                },
                                function(error){
                                    console.log(error);
                                }
                        );
            },
        },
        created : function(){
            if(this.$route.params.staffId){
                this.staff.id = this.$route.params.staffId;

                this.getStaff();
            }
        },
        mounted : function(){
            var vm = this;

            bus.$on('staff-found', function(staff){
                Vue.set(vm.$root,'pageTitle','Staff: ' + vm.staff.fullName);
            });

            bus.$on('staff-updated', function(staff){
                vm.$set(vm,'staff', staff);
                Vue.set(vm.$root,'pageTitle','Staff: ' + vm.staff.fullName);

            });

            bus.$on('refresh-staff', function(staff){
                vm.getStaff();
            });
        }
    }
</script>
