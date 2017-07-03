<template>
    <div>
        <div class="uk-flex uk-flex-right uk-margin-bottom uk-width-1-1">
            <button uk-toggle="target: #module-installer-modal" class="uk-button uk-button-primary">Install Module</button>
        </div>
        <div class="uk-child-width-1-5@m uk-flex uk-flex-between uk-grid-match uk-grid-small uk-width-1-1" uk-grid>
            <div v-for="module in modules">
                <a class="block block-link-hover3 uk-link-reset text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <i class="si si-puzzle fa-4x text-primary-darker"></i>
                        <div class="font-w600 push-15-t">{{ module.name }}</div>
                    </div>
                </a>
            </div>
        </div>

        <div id="module-installer-modal" uk-modal="center: true">
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <div class="uk-modal-header bg-ts">
                    <h2 class="uk-modal-title fg-white">Module Installer</h2>
                </div>
                <div class="uk-modal-body">
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <div class="upload" accept=".zip" uk-form-custom>
                                <input type="file">
                                <button class="uk-button uk-button-default" type="button" tabindex="-1">Upload a module</button>
                            </div>
                        </div>
                    </div>
                    <progress-bar :progress="progress"></progress-bar>
                </div>

            </div>
        </div>
    </div>
</template>
<style>
</style>
<script type="text/babel">
    //require('../../../../public/vendors/gridster/jquery.gridster.min.js');
    export default{
        data(){
            return{
                loadedWidgets : [],
                currentColumn : 1,
                currentRow : 1,
                modules : [],
                progress : 0
            }
        },
        methods : {
            loadModules : function () {
                var vm = this;

                vm.$http.get('/api/adminpanel/modules',
                        {
                            before : function(request){
                                //this.$root.notify("Fetching Role...");
                            }
                        }
                )
                        .then(
                                function(response){
                                    Vue.set(vm,'modules', response.data);
                                },
                                function(error){
                                    console.log(error);
                                }
                        );
            },
            moduleInstaller : function(){

            }
        },
        mounted : function(){
            this.$set(this.$root,'pageTitle','System Modules');

            var vm = this;

            vm.loadModules();

            var api_key = $('meta[name="api-key"]').attr('content');
            UIkit.upload('.upload', {

                url: '/api/controlpanel/modules/install-module?api_token=' + api_key,
                name: 'module',

                beforeSend: function() {
                    // todo:: check file type: ensure its a zip
                },
                //beforeAll: function() { console.log('beforeAll', arguments); },
                //load: function() { console.log('load', arguments); },
                error: function() { console.log('error', arguments); },
                complete: function(e) {
                    vm.$set(vm, 'progress',0);
                },
                /*
                 loadStart: function (e) {
                 vm.$root.progressBarMax =  e.total;
                 vm.$root.progressBarValue =  e.loaded;
                 },*/

                progress: function (e) {
                    vm.progress = (e.loaded / e.total);
                },
                /*
                 loadEnd: function (e) {
                 vm.$root.progressBarMax =  e.total;
                 vm.$root.progressBarValue =  e.loaded;
                 },
                 */
                completeAll: function () {
                    //console.log('completeAll', arguments);

                    /*setTimeout(function () {
                     // bar.setAttribute('hidden', 'hidden');
                     }, 1000);*/

                }
            });

        },
        components : {
            'progress-bar' : require('../../../../common/ProgressBar.vue')
        }
    }
</script>
