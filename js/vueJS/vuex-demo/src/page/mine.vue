<template lang="html">
  <div id="minePage">
  

  </div>

</template>
<script>
    import axios from 'axios'
    export default {
        data: function() {
            return {

            }
        },
        mounted: function() {
            console.log($('#qrcodeImg'));
            jQuery(function() {
                jQuery('#qrcodeImg').qrcode({
                    render: "canvas",
                    text: '1234567890',
                    height: 168,
                    width: 168,
                    background: "#ffd01b",
                    foreground: "#000"
                });
            });

            this.$store.commit('changeIndexConf', {
                isFooter: true,
                title:"我的",
                isHeader:true
            });
        },
        methods: {

        },
        computed: {}
    }
</script>

<style lang="scss">
    @import "../../static/css/mine.scss";
</style>