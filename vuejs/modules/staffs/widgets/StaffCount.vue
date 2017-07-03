<template>
    <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@m" uk-grid>
            <div class="uk-card-media-left uk-cover-container bg-darkMagenta uk-light">
                <div class="uk-position-center">
                    <i class="fa fa-briefcase fa-4x"></i>
                </div>

            </div>
            <div>
                <div class="uk-card-body">
                    <h3 class="uk-h1 uk-margin-remove-bottom uk-text-center">{{ totalStaffs }}</h3>
                    <p class="uk-text-lead uk-text-center uk-margin-remove">Staffs</p>
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
                totalStaffs : 0,
            }
        },

        methods : {
            loadStaffs : function(){
                var vm = this;

                vm.$http.get('/api/staffs/', {
                    before: function(request){
                        //this.$root.notify("Contacting server for Staffs... Please wait.");
                    }
                }).then(
                        function(response){
                            //console.log(response.data);
                            vm.$set(vm,'totalStaffs',response.data.length);
                        },
                        function(error){
                            console.log(error);

                            vm.$root.notify('Error loading staffs...', 'error');
                        }
                )
            },
        },

        mounted : function () {
            this.loadStaffs();
        }
    }
</script>
