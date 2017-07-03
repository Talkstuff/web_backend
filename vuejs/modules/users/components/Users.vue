<template>
    <div class="">
        <div class="uk-width-1-1">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">
                            <router-link :to="{name : 'users.new'}" class="uk-button uk-button-primary"
                            v-if="$root.hasPermission('user__add')">
                                <i class="fa fa-plus-circle"></i>
                                New User
                            </router-link>
                            <div class="uk-search uk-search-default">
                                <span class="uk-search-icon-flip" uk-search-icon></span>
                                <input class="uk-search-input"
                                       style="padding-right : 0px;" type="search" placeholder="Search..." v-model="search">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="uk-card-body">
                    <table class="uk-table" v-if="users && users.length">
                        <caption>showing {{ users ? users.length : 0 }} record(s).</caption>
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Full name</th>
                            <th>Display name</th>
                            <th>Username</th>
                            <th class="uk-table-shrink">Email</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(user, index) in users" :key="user.id" >
                            <td>{{index + 1}}</td>
                            <td>
                                <img class="uk-preserve-width uk-border-circle" :src="user.metadata.profileMediaSource"
                                     width="40" alt="">
                            </td>
                            <td>{{ user.fullName }}</td>
                            <td>{{ user.displayName }}</td>
                            <td>{{ user.username }}</td>
                            <td class="uk-table-shrink">{{ user.email }}</td>
                            <td class="uk-text-right">
                                <router-link :to="{name : 'users.details.home', params : {userId : user.id}}"
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
                <div class="uk-card-footer">
                    <ul class="uk-pagination uk-flex-center" uk-margin v-if="lastPage">
                        <li><a href="#"><span uk-pagination-previous></span></a></li>
                        <li v-for="page in lastPage"
                            :class="{'uk-active' : page == currentPage }"
                            @click="loadUsers(page)"><a href="javascript:void(0)">{{ page }}</a></li>
                        <li><a href="#"><span uk-pagination-next></span></a></li>
                    </ul>
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
                users : [],
                search : '',
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
                usernameExists : false,
                emailExists : false,
                currentPage : 0,
                lastPage : null
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
                    })
                }
            },
            loadUsers : function(page = null){
                var vm = this;

                vm.$http.get('/api/users/', {
                    before: function(request){
                        vm.$set(vm.$root,'loadingData',true);

                        if( page ) {
                            request.params.page = page;
                        } else {
                            request.params.page = vm.currentPage++;
                        }

                        this.$root.notify("Contacting server for Users... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'users',response.data.users);
                            vm.$set(vm,'currentPage',response.data.current_page);
                            vm.$set(vm,'lastPage',response.data.last_page);
                            vm.$set(vm.$root,'loadingData',false);

                            this.$root.notify(vm.users.length + " user(s) found.", 'success');
                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading users...', 'error');
                        }
                )
            },
            save : function(){
                var vm = this;

                vm.$http.post('/api/users/save', this.user,{
                    before : function(){
                        vm.$root.notify('Creating user: ' + vm.user.firstName);
                    }
                }).then(
                        function(response){
                            if(!vm.user.id){ // we are creating a new user, so we push into the array
                                vm.users.push(response.data);
                            }

                            vm.$root.notify('Saved! ' + vm.user.name, 'success');

                        },
                        function(error){

                        }
                );
            },
            searchFromServer : function(query){
                var vm = this;

                vm.$http.get('/api/users/' + query + '/search',{
                    before : function(request){
                        request.params.searching = true;
                        vm.$set(vm.$root,'loadingData',true);
                    }
                })
                        .then(
                                function(response){
                                    vm.$set(vm,'users',response.data.users);
                                    vm.$set(vm,'currentPage',response.data.current_page);
                                    vm.$set(vm,'lastPage',response.data.last_page);
                                    vm.$set(vm.$root,'loadingData',false);

                                },
                                function(error){
                                    console.log(error);
                                }
                        );
            },
            addToUsersMemory : function(result){
                console.log(result);
                if(result && result.length){
                    var vm = this;

                    for (var i=0;i<result.length;i++){
                        var addUser = result[i];

                        var found = _.find(vm.users, function(item){
                            if(_.isEqual(item, addUser)) return true;
                        });

                        if(!found) vm.users.push(result[i]);
                    }
                }
            }
        },
        beforeCreate : function(){
            Vue.set(this.$root,'pageTitle','Users');
        },
        mounted : function(){
            this.loadUsers();

            var vm = this;

            this.$watch('search', function(newVal, oldVal){
                if(newVal.length && (newVal !== oldVal)){
                    vm.searchFromServer(this.search);
                } else {
                    vm.loadUsers(1);
                }
            });
        }
    }
</script>

