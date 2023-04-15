import Vue from 'vue'
import VueRouter from 'vue-router'
import $ from 'jquery'
Vue.use(VueRouter)

// ========== define route==========
const routes = [
    {
        path: '/admin/login', component: () => import('./../views/auth/Login.vue'),
    },

]

// ========== define router==========
const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    base: process.env.MIX_VUE_ROUTER_BASE,
    linkExactActiveClass: "active",
    scrollBehavior() {
        return { x: 0, y: 0 };
    }
});
router.beforeEach((to, from, next) => {
    // active parent menu
    $('#preloader').fadeIn(10);
    // $('html').css('overflow',"hidden");
    setTimeout(() => {
        $('#preloader').fadeOut('slow');
        // $('html').css('overflow',"auto");
    }, 1000);
    next();
})

export default router
