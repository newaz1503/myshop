<template>
  <div>
    <FlashMessage :position="'right top'"></FlashMessage>
    <keep-alive>
      <router-view></router-view>
    </keep-alive>
  </div>
</template>


<script>
export default {

};
</script>

<style lang="scss">
    ._vue-flash-msg-body {
        width: 25% !important;
        z-index: 9999999;
    }
    ._vue-flash-msg-body__content{
        padding: 10px 5px;
        ._vue-flash-msg-body__title{
            font-size: 1.1rem;
        }
        ._vue-flash-msg-body__text{
            font-size: 0.9rem;
        }
    }
</style>
