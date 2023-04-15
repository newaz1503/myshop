import Vue from 'vue'
import VueRouter from 'vue-router'
import $ from 'jquery'
Vue.use(VueRouter)

// ========== define route==========
const routes = [
    {
        path: '/', component: () => import('./../views/frontend/Layout'),
        // chlidren menu
        children: [
            { path: '/login', name: 'login', component: () => import('../views/auth/FrontLogin') },
            { path: '/forget-password', name: 'forgetpassword', component: () => import('../views/auth/ForgetPassword') },
            { path: '/reset-password/:slug', name: 'resetpassword', component: () => import('../views/auth/ResetPassword') },
            { path: '/register', name: 'register', component: () => import('../views/auth/Registration') },
            { path: '/', name: 'home', component: () => import('./../views/frontend/ThemeLayout') },
            { path: '/home2', name: 'home2', component: () => import('./../views/frontend/Home2') },
            { path: '/home3', name: 'home3', component: () => import('./../views/frontend/Home3') },

            { /*==========USER DASHBOARD==========*/
                path: '/user',
                component: () => import('./../views/frontend/user/Layout'), beforeEnter: authGuard,
                children: [
                    { path: '/user/dashboard', name: 'user.dashboard', component: () => import('../views/frontend/user/pages/Dashboard'), beforeEnter: authGuard },
                    { path: '/user/profile', name: 'user.profile', component: () => import('../views/frontend/user/pages/Profile'), beforeEnter: authGuard },
                    { path: '/user/order-history', name: 'user.orders', component: () => import('../views/frontend/user/pages/Orders'), beforeEnter: authGuard },
                    { path: '/user/return-history', name: 'user.returns', component: () => import('../views/frontend/user/pages/Returns'), beforeEnter: authGuard },
                    { path: '/user/invoice/:id', name: 'user.order.invoice', component: () => import('../views/frontend/user/pages/Invoice'), beforeEnter: authGuard },
                    { path: '/user/wisthlist', name: 'user.wisthlist', component: () => import('../views/frontend/user/pages/Wisthlist'), beforeEnter: authGuard },
                    { path: '/user/change-password', name: 'user.change_password', component: () => import('../views/frontend/user/pages/ChangePassword'), beforeEnter: authGuard },
                    { path: '/user/trackorder', name: 'user.trackorder', component: () => import('../views/frontend/user/pages/trackorder'), beforeEnter: authGuard },
                ]
            },

            /*------SSL PAYMENT STATUS--------*/
            { path: '/ssl-payment-success', component: () => import('./../views/frontend/SSL/Success') },
            { path: '/ssl-payment-cancel', component: () => import('./../views/frontend/SSL/Cancel') },
            { path: '/ssl-payment-failed', component: () => import('./../views/frontend/SSL/Failed') },
            { path: 'stripe/checkout', component: () => import('./../views/frontend/pages/payment/StripeCheckout') },

            //Pages
            { path: '/products', name: 'products', component: () => import('./../views/frontend/pages/Products') },
            { path: '/product/:slug/details', name: 'productDetails', component: () => import('./../views/frontend/pages/ProductDetails') },
            { path: '/brands', name: 'brands', component: () => import('./../views/frontend/pages/Brands') },
            { path: '/categories', name: 'categories', component: () => import('./../views/frontend/pages/Categories') },
            { path: '/campaigns', name: 'campaigns', component: () => import('./../views/frontend/pages/Campaigns') },
            { path: '/campaign/:id/details', name: 'campaignsdetails', component: () => import('./../views/frontend/pages/CampaignsDetails') },
            { path: '/coupons', name: 'coupons', component: () => import('./../views/frontend/pages/Coupons') },

            { path: '/checkout', name: 'checkout', component: () => import('./../views/frontend/pages/Checkout'), beforeEnter: authGuard },
            { path: '/content-page/:slug', name: 'content.page', component: () => import('./../views/frontend/pages/TermsPolicies')},
            { path: '/about-us', name: 'about-us', component: () => import('./../views/frontend/pages/AboutUs')},
            { path: '/faq', name: 'faq', component: () => import('./../views/frontend/pages/Faq')},
            { path: '/contact-us', name: 'contact-us', component: () => import('./../views/frontend/pages/ContactUs')},
            { path: '/sectionwiseproduct/:slug', name: 'sectionWiseProduct', component: () => import('./../views/frontend/pages/sectionWiseProduct')},
        ],
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


// ==========check login or not==========
function authGuard(to, from, next) {
    if (User.loggedIn()) {
        next();
    } else {
        next({ name: 'login' });
    }
}

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
