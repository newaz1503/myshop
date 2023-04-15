require('./bootstrap');
window.Vue = require('vue').default;
require('./Helpers/Backend/crud');
require('./Helpers/Backend/mixin');
require('./Helpers/Backend/filter');
require('./Helpers/Backend/plugin');

import 'animate.css';

import store from  './vuex/cart';
// ===============router=============
import router from "./Router/router.js";
Vue.component('app', require('./components/BackendApp.vue').default);
Vue.component('header-component',require('./components/backend/HeaderComponent.vue').default)
Vue.component('sidebar-header',require('./components/backend/SidebarHeader.vue').default)
Vue.component('sidebar-navigation',require('./components/backend/SidebarComponent.vue').default)
Vue.component('footer-component',require('./components/backend/FooterComponent.vue').default)
// ===============app===============

const  events = new Vue();
Vue.prototype.$loader = events

const app = new Vue({
    el: '#layout-wrapper',
    store,
    router,
    data: {
        baseurl: laravel.baseurl,
        submit: false,
        spinner: false,
        loggedIn: false,
        tableSpinner: false,
        pageNumber: 1,
        isRequestDone: true,
        exception_errors: {},
        validation_errors: {},
        userimage: laravel.baseurl + '/public/images/user.png',
        noimage: laravel.baseurl + '/public/admin/images/uploa-image.jpg',
        attach: laravel.baseurl + '/public/images/attach.png',
        menus: [],
        global: [],
        site: {},
        permissions: [],
        settings: {},
    },
    methods: {
        getInitializeSystems() {
            axios.get('/initialize-systems').then(res => {
                this.site = res.data.site;
                this.menus = res.data.menus;
                this.global = res.data.global;
                this.permissions = res.data.permissions;
                this.settings = res.data.settings;
                profile.dispatch("setProfile", res.data.profile);
            });
        },
        checkPermission(route) {
            let routeName = !route ? this.$route.name : route;
            let check = this.permissions.filter(x => x == routeName);
            return Object.keys(check).length > 0 ? true : false
        },
    },
    mounted() {
        if (Boolean(Admin.loggedIn())) {
            this.getInitializeSystems();
        }
        this.loggedIn = Boolean(Admin.loggedIn());
    }
});
