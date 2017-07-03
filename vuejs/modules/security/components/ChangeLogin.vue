<template>
    <div>
        <div class="uk-flex uk-flex-center" uk-grid>
            <div class="uk-width-2-3@m">
                <div class="uk-card uk-card-default">
                    <form @submit.prevent="changePassword()">
                        <div class="uk-card-body">
                            <div class="uk-margin">
                                <label class="uk-form-label" for="account.oldPassword">Old Password:</label>
                                <div class="uk-form-controls">
                                    <input id="account.oldPassword"  v-model="account.oldPassword" placeholder="Your old password" required
                                           class="uk-input uk-form-width-expand" type="password" autofocus>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="account.newPassword">New Password:</label>
                                <div class="uk-form-controls">
                                    <input id="account.newPassword"  v-model="account.newPassword"
                                           placeholder="Your new password" required
                                           class="uk-input uk-form-width-expand" type="password">
                                </div>

                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label">Retype New Password:</label>
                                <div class="uk-form-controls">
                                    <input type="password" class="uk-input uk-form-width-expand"
                                           v-model="account.confirmPassword"
                                           placeholder="Retype your new password to confirm" required>
                                </div>
                            </div>
                        </div>
                        <div class="uk-card-footer">
                            <button type="submit" class="uk-button uk-button-primary">Submit</button>
                        </div>
                    </form>
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
                account : {
                    oldPassword : '',
                    newPassword : '',
                    confirmPassword : ''
                }
            }
        },
        methods : {
            changePassword : function(){
                var vm = this;

                vm.$http.post('/api/security/change-password',vm.account,{
                    before : function(request){
                        vm.$root.notify('Changing your login details. Please wait');
                    }
                }).then(
                    function (response) {
                        vm.$root.notify('Password update was successful.', 'success');

                        //console.log(response);
                    },
                    function (error) {
                        console.log(error);
                        vm.$root.notify(error.data.message,'error');
                    }
                )
            }
        },
        beforeCreate : function(){
            Vue.set(this.$root,'pageTitle','Change Password');
        },
        mounted : function(){
            var vm = this;

        }
    }
</script>
