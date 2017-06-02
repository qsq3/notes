<template lang="html">
  <div id="balancePage">
    大大大
  </div>
</template>

<script>
    import axios from 'axios'
    // import router from '../router/router'

    export default {
        data: function() {
            return {
                tab1Active: true,
                tab2Active: false

            }
        },
        created: function() {

            this.$store.commit('changeIndexConf', {
                isFooter: false
            })
        },
        methods: {
            tabSwitch: function(status) {
                if (status == "tab1Active") {
                    this.tab1Active = true;
                    this.tab2Active = false;
                } else if (status == "tab2Active") {
                    this.tab1Active = false;
                    this.tab2Active = true;
                }

            }
        },
        computed: {}
    }
</script>

<style lang="scss">
    @import "../../static/css/balance.scss";
</style>