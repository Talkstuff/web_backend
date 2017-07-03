<template>
    <div v-show="progress" class="progress" id="progress"></div>
</template>
<style>
    .progress {
        height: 2px;
     }
    .progress > svg {
        height: 100%;
        display: block;
    }
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                progressBar : null
            }
        },
        props : ['progress'],
        methods : {
            move(val){
                this.progressBar.animate(val);
            }
        },
        mounted(){
            var ProgressBar = require('progressbar.js');

            this.progressBar = new ProgressBar.Line('#progress',{
                color: '#ff6600',
                duration: 2000,
                easing: 'easeInOut',
            });

            var vm = this;

            this.$watch('progress', function(newVal, oldVal){
                vm.move(newVal);
            })
        }
    }
</script>
