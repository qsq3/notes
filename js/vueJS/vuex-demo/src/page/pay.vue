<template lang="html">

   
</template>

<script>
    import axios from 'axios'
    export default {
        data: function() {
            return {
                isSelect: true,
                isBanance: true
            }
        },
        created: function() {

            this.$store.commit('changeIndexConf', {
                isFooter: false
            })
        },
        methods: {

            select: function() {
                // console.log(this.isSelect)
                return this.isSelect = !this.isSelect;
            },
            selectBalance: function() {
                return this.isBanance = !this.isBanance;
            }
        },
        computed: {}
    }
</script>
<style lang="scss">
    @import "../../static/css/pay.scss";
</style>