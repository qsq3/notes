<!--充值中心-->
<template lang="html">


</template>

<script>
    import axios from 'axios'
    export default {
        data: function() {
            return {

            }
        },
        mounted: function() {
            this.$store.commit('changeIndexConf', {
                isFooter: false
            });
        },
        methods: {

        },
        computed: {}
    }
</script>

<style lang="scss">
    @import "../../static/css/rechargeCenter.scss";
</style>