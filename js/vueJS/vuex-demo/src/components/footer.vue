<template>
  <div class="footer">
      <router-link to="/index"  id="index"  ><div class="img_style"></div>
       </router-link>
      <router-link to="/home" id="home"><div class="img_style"></div>
       </router-link>
        <router-link to="/mine" id="mine"><div class="img_style"></div>
        </router-link>
   
  </div>
</template>
<script>
    export default {
        data: function() {
            return {
              
            }
        },
        methods: {
          
        }
       

    }
</script>
<style lang="scss">
    @import "../../static/css/footer.scss";
</style>