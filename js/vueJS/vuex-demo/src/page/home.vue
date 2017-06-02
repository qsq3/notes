<template>
 
</template>
<script>
    import axios from 'axios'
    // import router from '../router/router'

    export default {
        data: function() {
            return {

            }
        },
        created: function() {

            this.$store.commit('changeIndexConf', {
                isFooter: true,
                title:"xxx"

            })
        },
        methods: {

        },
        computed: {}
    }
</script>
<style lang="scss">
    @import "../../static/css/home.scss";
</style>