<template lang="html">

</div>
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
                isFooter: false
            })
        },
        methods: {

        },
        computed: {}
    }

    function load() {
        // document.addEventListener('touchmove', function(e) {
        //     e.preventDefault();
        // }, false);
        // var startY, endY, distance;
        // $("html").on("touchstart", function(e) {
        //     // console.log(e)
        //     startY = e.touches[0].clientY;
        // })

        // $("html").on("touchend", function(e) {
        //     endY = e.changedTouches[0].clientY;

        //     distance = startY - endY;

        //     if (distance > 100) {
        //         console.log(distance);
        //         $(".loading").addClass("translate");
        //         setTimeout(function() {
        //             $(".loading").removeClass("translate")
        //         }, 2000)
        //     }
        // })
    }
    load();
</script>

<style lang="scss">
    @import "../../static/css/growup.scss";
</style>