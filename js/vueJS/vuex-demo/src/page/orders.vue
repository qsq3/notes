<template lang="html">
  
</template>

<script>
    import axios from 'axios'
    // import router from '../router/router'

    export default {
        data: function() {
            return {
                tab1Active: true,
                tab2Active: false,
                tab3Active: false
            }
        },
        created: function() {

            this.$store.commit('changeIndexConf', {
                isFooter: false
            })
        },
        methods: {
            tabSwitch: function(tab) {
                if (tab == "tab1Active") {
                    this.tab1Active = true;
                    this.tab2Active = false;
                    this.tab3Active = false;
                }
                if (tab == "tab2Active") {
                    this.tab1Active = false;
                    this.tab2Active = true;
                    this.tab3Active = false;
                }
                if (tab == "tab3Active") {
                    this.tab1Active = false;
                    this.tab2Active = false;
                    this.tab3Active = true;

                }
            }
        },
        computed: {}
    }
</script>

<style lang="scss">
    @import "../../static/css/orders.scss";
</style>