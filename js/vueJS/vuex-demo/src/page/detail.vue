<template lang="html">
  <div class="">
    details
  </div>
</template>

<script>
    import axios from 'axios'
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
</script>

<style lang="css">

</style>