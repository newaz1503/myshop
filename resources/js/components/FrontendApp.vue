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
  methods: {
    loginCheck() {
      axios.get("/login-check").then((res) => {
        if (res.status == 200) {
          User.login(res.data);
        } else {
          if (User.loggedIn()) {
            User.logout();
          }
        }
      });
    },
  },
  created() {
    this.loginCheck();
  },
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
