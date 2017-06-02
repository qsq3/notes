<template>
  <div class="index">
    
  </div>
</template>

<script>
   
    import axios from 'axios'

    export default {
        data: function() {
            return {
                
            }
        },
        created() {
            // head的修改
            this.$store.commit('changeIndexConf', {
                isFooter: true,
                isHeader:true,
                title:"首页"

            })
        },
        components: {

        },
        computed: {},
        watch: {

        },
        methods: {



        }
    }
</script>
<style lang="scss">
    @import "../../static/css/index.scss";
</style>