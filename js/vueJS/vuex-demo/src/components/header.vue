<template>
  <div class="header">

    <div class="title">
      <a v-show="isBack" class="back t-icon" @click="goBack"><span
        class="iconfont icon icon-xiangzuojiantou"></span></a>
      <p>{{title}}</p>
    </div>
  </div>
</template>

<script>

    export default {
        data: function() {
            return {}
        },
        computed: {
            isShowSearch: function() {
                return this.$store.state.comm.indexConf.isSearch
            },
            title: function() {
                return this.$store.state.comm.indexConf.title
            },
            isBack: function() {
                return this.$store.state.comm.indexConf.isBack
            }
        },
        methods: {
            goBack: function() {
                history.go(-1)
            },
            add: function() {
                console.log('ee')
            }
        },
        components: {
            
        }
    }
</script>
<style lang="scss">
    @import "../../static/css/header.scss";
</style>
