<template>
    <div class="uk-container-expand" uk-height-viewport style="padding-left: 0;padding-right: 0px;min-height: 100vh;">
        <div class="uk-grid-collapse uk-background-cover uk-background-top-center uk-height-1-1"
             style="background-image: url(/shared/images/ipad-750.jpg);">

            <div class="login-overlay bg-ts uk-width-1-1 uk-height-1-1 uk-position-top"
                 style="z-index: 1"></div>

            <div class="uk-width-1-1 uk-flex uk-flex-center">
                <div class="uk-padding uk-width-1-3@m" style="z-index: 10" >
                    <div class="uk-border-rounded uk-padding uk-position-relative "
                         style="background-color: rgba(255, 255, 255, 0.84)">

                        <div class="uk-background-contain uk-height-small uk-width-1-1"
                             style="background-image: url(/shared/images/tslogo2.png); "></div>
                        <div class="uk-width-1-1 uk-margin-remove-top fg-white uk-margin-large-bottom uk-text-center uk-h2">
                            <small class="fg-black">System Login</small>
                        </div>

                        <form class="uk-flex uk-margin-top uk-flex-column uk-flex-between"
                              uk-grid method="post" @submit.prevent="login()">

                            <div class="uk-width-1-1" uk-margin>
                                <input class="uk-input uk-width-1-1 uk-form-medium" type="text" v-model="username"
                                       placeholder="Username" autofocus>

                                <input class="uk-input uk-width-1-1 uk-form-medium" type="password" v-model="password"  placeholder="Password">
                            </div>

                            <div class="uk-width-1-1" uk-margin>
                                <button class="uk-button bg-orange bg-hover-amber fg-white uk-width-1-1 uk-button-large"
                                        :disabled="!validated" type="submit">Login</button>
                            </div>
                        </form>

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
                username : '',
                password : '',
                loggingIn : false,
                logInButtonText : 'Login',
            }
        },
        props : ['platform'],
        methods:{
            login : function(){
                // TODO:: login the user
                var vm = this;
                vm.$http.post('/security/adminpanel/login',{username : this.username, password : this.password},
                        {
                            before: function(request){
                                this.$root.notify("Logging in... Please wait.");
                            }
                        })
                        .then(
                                // success callback
                                function(response){

                                    vm.$root.notify("Redirecting...",'success');

                                    bus.$emit('user-logged-in', response);

                                }, // error callback
                                function(error){
                                    vm.$root.notify(error.data.message, 'danger');
                                });
            }
        },
        created : function(){
            //console.log(this.platform);
            //this.siteInfo = JSON.parse(this.site);
        },
        computed : {
            validated : function(){
                if(this.username.length && this.password.length){
                    return true;
                }
                return false;
            }
        },
        mounted : function () {
            this.$set(this.$root,'loadingApp',false);
        }
    }
</script>
