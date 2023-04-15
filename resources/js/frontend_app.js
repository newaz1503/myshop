require('./frontend_bootstrap');
window.Vue = require('vue').default;
require('./Helpers/Frontend/crud');
require('./Helpers/Backend/filter');
require('./Helpers/Frontend/mixin');
require('./Helpers/Frontend/plugin');

import 'animate.css';
// ===============router=============
import router from "./Router/frontend_router.js";

import Product from './views/frontend/components/Product';
import HorizontalProduct from './views/frontend/components/HorizontalProduct';
import store from  './vuex/frontend_cart';

Vue.component('Product', Product);
Vue.component('HorizontalProduct', HorizontalProduct);
Vue.component('frontend-app', require('./components/FrontendApp.vue').default);
// ===============app===============
const app = new Vue({
    el: '#frontend-app',
    store,
    router,
    data: {
        baseurl: laravel.baseurl,
        spinner: false,
        userLoggedIn: false,
        userimage: laravel.baseurl + '/public/images/user.png',
        noimage: laravel.baseurl + '/public/images/noimage.png',
        attach: laravel.baseurl + '/public/images/attach.png',
        pageNumber: 1,
        global: []
    },
    methods: {
        globalData: function () {
            axios.get('/global-data').then(res => {
                this.global = res.data
            });
        },
    },
    async mounted() {
        await this.globalData();
        this.userLoggedIn = Boolean(User.loggedIn());
    },
});
