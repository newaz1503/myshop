import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// ========== define route==========
const routes = [
    { // allow for after login

        path: '/dashboard', component: () => import('./../views/backend/Layout'), beforeEnter: authGuard,
        // chlidren menu
        children: [
            // ------------------MENU PORTION------------------
            { path: '/frontMenu', name: 'frontMenu.index', meta: { title: 'Menu', nav: true }, component: () => import('./../views/backend/Website/Menu/Index'), beforeEnter: authGuard },
            { path: '/frontMenu/create', name: 'frontMenu.create', component: () => import('./../views/backend/Website/Menu/Create'), beforeEnter: authGuard },
            { path: '/frontMenu/:id', name: 'frontMenu.show', component: () => import('./../views/backend/Website/Menu/View'), beforeEnter: authGuard },
            { path: '/frontMenu/:id/edit', name: 'frontMenu.edit', component: () => import('./../views/backend/Website/Menu/Create'), beforeEnter: authGuard },
            // ------------------CONTENT PORTION------------------
            { path: '/content/:slug', name: 'content.show', component: () => import('./../views/backend/Website/Content/View'), beforeEnter: authGuard },
            { path: '/content/:slug/create', name: 'content.create', component: () => import('./../views/backend/Website/Content/Create'), beforeEnter: authGuard },
            { path: '/content-file/:slug', name: 'content.file', component: () => import('./../views/backend/Website/Content/CreateFile'), beforeEnter: authGuard },

            // ------------------PAGE PORTION------------------
            { path: '/page', name: 'page.index', meta: { title: 'Page', nav: true }, component: () => import('./../views/backend/Page/Index'), beforeEnter: authGuard },
            { path: '/page/create', name: 'page.create', component: () => import('./../views/backend/Page/Create'), beforeEnter: authGuard },
            { path: '/page/:id', name: 'page.show', component: () => import('./../views/backend/Page/View'), beforeEnter: authGuard },
            { path: '/page/:id/edit', name: 'page.edit', component: () => import('./../views/backend/Page/Create'), beforeEnter: authGuard },


            // Ecommerce route
            // ------------------CATEGORY PORTION------------------
            { path: '/category', name: 'category.index', meta: { title: 'Category', nav: true }, component: () => import('./../views/backend/Category/Index'), beforeEnter: authGuard },
            { path: '/category/create', name: 'category.create', component: () => import('./../views/backend/Category/Create'), beforeEnter: authGuard },
            { path: '/category/:id', name: 'category.show', component: () => import('./../views/backend/Category/View'), beforeEnter: authGuard },
            { path: '/category/:id/edit', name: 'category.edit', component: () => import('./../views/backend/Category/Create'), beforeEnter: authGuard },

            // ------------------BRAND PORTION------------------
            { path: '/brand', name: 'brand.index', meta: { title: 'Brand', nav: true }, component: () => import('./../views/backend/Brand/Index'), beforeEnter: authGuard },
            { path: '/brand/create', name: 'brand.create', component: () => import('./../views/backend/Brand/Create'), beforeEnter: authGuard },
            { path: '/brand/:id', name: 'brand.show', component: () => import('./../views/backend/Brand/View'), beforeEnter: authGuard },
            { path: '/brand/:id/edit', name: 'brand.edit', component: () => import('./../views/backend/Brand/Create'), beforeEnter: authGuard },


            // ------------------PRODUCT PORTION------------------
            { path: '/product', name: 'product.index', meta: { title: 'Product', nav: true }, component: () => import('./../views/backend/Product/Index'), beforeEnter: authGuard },
            { path: '/product/stockout', name: 'product.stockout', meta: { title: 'Stockout Product', nav: true }, component: () => import('./../views/backend/Product/Stockout'), beforeEnter: authGuard },
            { path: '/product/create', name: 'product.create', component: () => import('./../views/backend/Product/Create'), beforeEnter: authGuard },
            { path: '/product/:id', name: 'product.show', component: () => import('./../views/backend/Product/View'), beforeEnter: authGuard },
            { path: '/product/:id/edit', name: 'product.edit', component: () => import('./../views/backend/Product/Create'), beforeEnter: authGuard },
            { path: '/product/bulkexport', name: 'product.bulkexport', component: () => import('./../views/backend/Product/Bulkexport'), beforeEnter: authGuard },

            // ------------------CAMPAIGNOFFER PORTION------------------
            { path: '/campaignOffer', name: 'campaignOffer.index', meta: { title: 'CampaignOffer', nav: true }, component: () => import('./../views/backend/CampaignOffer/Index'), beforeEnter: authGuard },
            { path: '/campaignOffer/create', name: 'campaignOffer.create', component: () => import('./../views/backend/CampaignOffer/Create'), beforeEnter: authGuard },
            { path: '/campaignOffer/:id', name: 'campaignOffer.show', component: () => import('./../views/backend/CampaignOffer/View'), beforeEnter: authGuard },
            { path: '/campaignOffer/:id/edit', name: 'campaignOffer.edit', component: () => import('./../views/backend/CampaignOffer/Create'), beforeEnter: authGuard },


            // ------------------ORDER PORTION------------------
            { path: '/order', name: 'order.index', meta: { title: 'Order', nav: true }, component: () => import('./../views/backend/Order/Index'), beforeEnter: authGuard },
            { path: '/order/create', name: 'order.create', component: () => import('./../views/backend/Order/Create'), beforeEnter: authGuard },
            { path: '/order/:id', name: 'order.show', component: () => import('./../views/backend/Order/View'), beforeEnter: authGuard },
            { path: '/order/:id/edit', name: 'order.edit', component: () => import('./../views/backend/Order/Create'), beforeEnter: authGuard },


            //Ecommerser Setup
            // ------------------ATTRIBUTE PORTION------------------
            { path: '/attribute', name: 'attribute.index', meta: { title: 'Attribute', nav: true }, component: () => import('./../views/backend/Attribute/Index'), beforeEnter: authGuard },
            { path: '/attribute/create', name: 'attribute.create', component: () => import('./../views/backend/Attribute/Create'), beforeEnter: authGuard },
            { path: '/attribute/:id', name: 'attribute.show', component: () => import('./../views/backend/Attribute/View'), beforeEnter: authGuard },
            { path: '/attribute/:id/edit', name: 'attribute.edit', component: () => import('./../views/backend/Attribute/Create'), beforeEnter: authGuard },
            // ------------------COUPON PORTION------------------
            { path: '/coupon', name: 'coupon.index', meta: { title: 'Coupon', nav: true }, component: () => import('./../views/backend/Coupon/Index'), beforeEnter: authGuard },
            { path: '/coupon/create', name: 'coupon.create', component: () => import('./../views/backend/Coupon/Create'), beforeEnter: authGuard },
            { path: '/coupon/:id', name: 'coupon.show', component: () => import('./../views/backend/Coupon/View'), beforeEnter: authGuard },
            { path: '/coupon/:id/edit', name: 'coupon.edit', component: () => import('./../views/backend/Coupon/Create'), beforeEnter: authGuard },

            // ------------------SHIPPING PORTION------------------
            { path: '/shipping', name: 'shipping.index', meta: { title: 'Shipping', nav: true }, component: () => import('./../views/backend/Shipping/Index'), beforeEnter: authGuard },
            { path: '/shipping/create', name: 'shipping.create', component: () => import('./../views/backend/Shipping/Create'), beforeEnter: authGuard },
            { path: '/shipping/:id', name: 'shipping.show', component: () => import('./../views/backend/Shipping/View'), beforeEnter: authGuard },
            { path: '/shipping/:id/edit', name: 'shipping.edit', component: () => import('./../views/backend/Shipping/Create'), beforeEnter: authGuard },
            // ------------------STATE PORTION------------------
            { path: '/state', name: 'state.index', meta: { title: 'State', nav: true }, component: () => import('./../views/backend/State/Index'), beforeEnter: authGuard },
            { path: '/state/create', name: 'state.create', component: () => import('./../views/backend/State/Create'), beforeEnter: authGuard },
            { path: '/state/:id', name: 'state.show', component: () => import('./../views/backend/State/View'), beforeEnter: authGuard },
            { path: '/state/:id/edit', name: 'state.edit', component: () => import('./../views/backend/State/Create'), beforeEnter: authGuard },
            // ------------------TAX PORTION------------------
            { path: '/tax', name: 'tax.index', meta: { title: 'Tax', nav: true }, component: () => import('./../views/backend/Tax/Index'), beforeEnter: authGuard },
            { path: '/tax/create', name: 'tax.create', component: () => import('./../views/backend/Tax/Create'), beforeEnter: authGuard },
            { path: '/tax/:id', name: 'tax.show', component: () => import('./../views/backend/Tax/View'), beforeEnter: authGuard },
            { path: '/tax/:id/edit', name: 'tax.edit', component: () => import('./../views/backend/Tax/Create'), beforeEnter: authGuard },
            // ------------------CURRENCY PORTION------------------
            { path: '/currency', name: 'currency.index', meta: { title: 'Currency', nav: true }, component: () => import('./../views/backend/Currency/Index'), beforeEnter: authGuard },
            { path: '/currency/create', name: 'currency.create', component: () => import('./../views/backend/Currency/Create'), beforeEnter: authGuard },
            { path: '/currency/:id', name: 'currency.show', component: () => import('./../views/backend/Currency/View'), beforeEnter: authGuard },
            { path: '/currency/:id/edit', name: 'currency.edit', component: () => import('./../views/backend/Currency/Create'), beforeEnter: authGuard },
            // ------------------VENDOR PORTION------------------
            { path: '/vendor', name: 'vendor.index', meta: { title: 'Vendor', nav: true }, component: () => import('./../views/backend/Vendor/Index'), beforeEnter: authGuard },
            { path: '/vendor/create', name: 'vendor.create', component: () => import('./../views/backend/Vendor/Create'), beforeEnter: authGuard },
            { path: '/vendor/:id', name: 'vendor.show', component: () => import('./../views/backend/Vendor/View'), beforeEnter: authGuard },
            { path: '/vendor/:id/edit', name: 'vendor.edit', component: () => import('./../views/backend/Vendor/Create'), beforeEnter: authGuard },

            // ------------------SALE PORTION------------------
            { path: '/sale', name: 'sale.index', meta: { title: 'Sale', nav: true }, component: () => import('./../views/backend/Sale/Index'), beforeEnter: authGuard },
            { path: '/sale/create', name: 'sale.create', component: () => import('./../views/backend/Sale/Create'), beforeEnter: authGuard },
            { path: '/sale/:id', name: 'sale.show', component: () => import('./../views/backend/Sale/View'), beforeEnter: authGuard },
            { path: '/sale/:id/edit', name: 'sale.edit', component: () => import('./../views/backend/Sale/Create'), beforeEnter: authGuard },

            // ------------------FAQ PORTION------------------
            { path: '/faq', name: 'faq.index', meta: { title: 'Faq', nav: true }, component: () => import('./../views/backend/Faq/Index'), beforeEnter: authGuard },
            { path: '/faq/create', name: 'faq.create', component: () => import('./../views/backend/Faq/Create'), beforeEnter: authGuard },
            { path: '/faq/:id', name: 'faq.show', component: () => import('./../views/backend/Faq/View'), beforeEnter: authGuard },
            { path: '/faq/:id/edit', name: 'faq.edit', component: () => import('./../views/backend/Faq/Create'), beforeEnter: authGuard },
            // ------------------SUBSCRIBER PORTION------------------
            { path: '/subscriber', name: 'subscriber.index', meta: { title: 'Subscriber', nav: true }, component: () => import('./../views/backend/Subscriber/Index'), beforeEnter: authGuard },
            { path: '/subscriber/create', name: 'subscriber.create', component: () => import('./../views/backend/Subscriber/Create'), beforeEnter: authGuard },
            { path: '/subscriber/:id', name: 'subscriber.show', component: () => import('./../views/backend/Subscriber/View'), beforeEnter: authGuard },
            { path: '/subscriber/:id/edit', name: 'subscriber.edit', component: () => import('./../views/backend/Subscriber/Create'), beforeEnter: authGuard },
            // ------------------FRONTEND SETTING PORTION------------------
            { path: '/setting/general', name: 'setting.general', component: () => import('./../views/backend/Website/Settings/General'), beforeEnter: authGuard },
            { path: '/setting/homepage', name: 'setting.homepage', component: () => import('./../views/backend/Website/Settings/Homepage'), beforeEnter: authGuard },
            { path: '/setting/payment-methods', name: 'setting.payment_methods', component: () => import('./../views/backend/Website/Settings/PaymentMethod'), beforeEnter: authGuard },
            { path: '/setting/footer', name: 'setting.footer', component: () => import('./../views/backend/Website/Settings/FooterSetting'), beforeEnter: authGuard },
            { path: '/setting/social-login', name: 'setting.socialLogin', component: () => import('./../views/backend/Website/Settings/SocialLogin'), beforeEnter: authGuard },

            // Admin Report
            // Top sale products
            { path:'/report/topsale', name:'report.topsale', component:()=> import('./../views/backend/Reports/topsale'),beforeEnter:authGuard},
             //Date Wise Sale Report
             { path:'/report/datewisesale', name:'report.datewisesale', component:()=> import('./../views/backend/Reports/datewisesale'),beforeEnter:authGuard},
            //Unpaid Customer Report
            { path:'/report/unpaidcustomers', name:'report.unpaidcustomers', component:()=> import('./../views/backend/Reports/unpaidcustomers'),beforeEnter:authGuard},
            //POS and Registered Customers
            { path:'/report/customertypewisesale', name:'report.customertypewisesale', component:()=> import('./../views/backend/Reports/customertypewisesale'),beforeEnter:authGuard},
            // ------------------EMAIL SETTING PORTION------------------
            { path: '/setting/email/setting', name: 'setting.emailSettings', component: () => import('./../views/backend/Website/Settings/EmailSetting'), beforeEnter: authGuard },

            // ------------------SLIDER PORTION------------------
            { path: '/slider', name: 'slider.index', meta: { title: 'Slider', nav: true }, component: () => import('./../views/backend/Website/Gallery/Slider/Index'), beforeEnter: authGuard },
            { path: '/slider/create', name: 'slider.create', component: () => import('./../views/backend/Website/Gallery/Slider/Create'), beforeEnter: authGuard },
            { path: '/slider/:id', name: 'slider.show', component: () => import('./../views/backend/Website/Gallery/Slider/View'), beforeEnter: authGuard },
            { path: '/slider/:id/edit', name: 'slider.edit', component: () => import('./../views/backend/Website/Gallery/Slider/Create'), beforeEnter: authGuard },
            // ------------------SERVICE PORTION------------------
            { path: '/service', name: 'service.index', meta: { title: 'Service', nav: true }, component: () => import('./../views/backend/Service/Index'), beforeEnter: authGuard },
            { path: '/service/create', name: 'service.create', component: () => import('./../views/backend/Service/Create'), beforeEnter: authGuard },
            { path: '/service/:id', name: 'service.show', component: () => import('./../views/backend/Service/View'), beforeEnter: authGuard },
            { path: '/service/:id/edit', name: 'service.edit', component: () => import('./../views/backend/Service/Create'), beforeEnter: authGuard },
            // ------------------USER PORTION------------------
            { path: '/user', name: 'user.index', meta: { title: 'User', nav: true }, component: () => import('./../views/backend/User/Index'), beforeEnter: authGuard },
            { path: '/user/create', name: 'user.create', component: () => import('./../views/backend/User/Create'), beforeEnter: authGuard },
            { path: '/user/:id', name: 'user.show', component: () => import('./../views/backend/User/View'), beforeEnter: authGuard },
            { path: '/user/:id/edit', name: 'user.edit', component: () => import('./../views/backend/User/Create'), beforeEnter: authGuard },

            // ------------------ACCOUNTHEAD PORTION------------------
            { path: '/accountHead', name: 'accountHead.index', meta: { title: 'AccountHead', nav: true }, component: () => import('./../views/backend/MasterSetup/AccountHead/Index'), beforeEnter: authGuard },
            { path: '/accountHead/create', name: 'accountHead.create', component: () => import('./../views/backend/MasterSetup/AccountHead/Create'), beforeEnter: authGuard },
            { path: '/accountHead/:id', name: 'accountHead.show', component: () => import('./../views/backend/MasterSetup/AccountHead/View'), beforeEnter: authGuard },
            { path: '/accountHead/:id/edit', name: 'accountHead.edit', component: () => import('./../views/backend/MasterSetup/AccountHead/Create'), beforeEnter: authGuard },
            // ------------------INVOICE PORTION------------------
            { path: '/invoice', name: 'invoice.index', meta: { title: 'Invoice', nav: true }, component: () => import('./../views/backend/Invoice/Index'), beforeEnter: authGuard },
            { path: '/invoice/create', name: 'invoice.create', component: () => import('./../views/backend/Invoice/Create'), beforeEnter: authGuard },
            { path: '/invoice/:id', name: 'invoice.show', component: () => import('./../views/backend/Invoice/View'), beforeEnter: authGuard },
            { path: '/invoice/:id/edit', name: 'invoice.edit', component: () => import('./../views/backend/Invoice/Create'), beforeEnter: authGuard },


            // ------------------ADMIN PORTION------------------
            { path: '/dashboard', name: 'admin.dashboard', meta: { title: 'Dashboard', nav: true }, component: () => import('./../views/backend/Admin/Dashboard'), beforeEnter: authGuard },
            { path: '/sitemap', name: 'admin.sitemap', component: () => import('./../views/backend/Admin/Sitemap'), beforeEnter: authGuard },
            { path: '/admin', name: 'admin.index', meta: { title: 'Admin', nav: true }, component: () => import('./../views/backend/Admin/Index'), beforeEnter: authGuard },
            { path: '/admin/create', name: 'admin.create', component: () => import('./../views/backend/Admin/Create'), beforeEnter: authGuard },
            { path: '/admin/:id', name: 'admin.show', component: () => import('./../views/backend/Admin/View'), beforeEnter: authGuard },
            { path: '/admin/:id/edit', name: 'admin.edit', component: () => import('./../views/backend/Admin/Create'), beforeEnter: authGuard },
            // ------------------ROLE PORTION------------------
            { path: '/role', name: 'role.index', meta: { title: 'Role', nav: true }, component: () => import('./../views/backend/System/Role/Index'), beforeEnter: authGuard },
            { path: '/role/create', name: 'role.create', component: () => import('./../views/backend/System/Role/Create'), beforeEnter: authGuard },
            { path: '/role/:id', name: 'role.show', component: () => import('./../views/backend/System/Role/View'), beforeEnter: authGuard },
            { path: '/role/:id/edit', name: 'role.edit', component: () => import('./../views/backend/System/Role/Create'), beforeEnter: authGuard },
            // ------------------MENU PORTION------------------
            { path: '/menu', name: 'menu.index', meta: { title: 'Menu', nav: true }, component: () => import('./../views/backend/System/Menu/Index'), beforeEnter: authGuard },
            { path: '/menu/create', name: 'menu.create', component: () => import('./../views/backend/System/Menu/Create'), beforeEnter: authGuard },
            { path: '/menu/:id', name: 'menu.show', component: () => import('./../views/backend/System/Menu/View'), beforeEnter: authGuard },
            { path: '/menu/:id/edit', name: 'menu.edit', component: () => import('./../views/backend/System/Menu/Create'), beforeEnter: authGuard },
            // ------------------SITE SETTING PORTION------------------
            { path: '/siteSetting', name: 'siteSetting.index', meta: { title: 'Site Settings', nav: true }, component: () => import('./../views/backend/System/SiteSettings/Index'), beforeEnter: authGuard },
            { path: '/siteSetting/create', name: 'siteSetting.create', component: () => import('./../views/backend/System/SiteSettings/Create'), beforeEnter: authGuard },
            { path: '/siteSetting/:id', name: 'siteSetting.show', component: () => import('./../views/backend/System/SiteSettings/View'), beforeEnter: authGuard },
            { path: '/siteSetting/:id/edit', name: 'siteSetting.edit', component: () => import('./../views/backend/System/SiteSettings/Create'), beforeEnter: authGuard },

        ]
    },

    // if any component or view not found then showing 404 page
    {
        path: '*', component: () => import('./../views/backend/NotFoundLayout'), beforeEnter: authGuard,
        children: [
            { path: '*', name: '404', component: () => import('./../views/errors/404'), beforeEnter: authGuard }
        ]
    }
];



// ========== define router==========
const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    base: process.env.MIX_VUE_ROUTER_BASE + '/admin/',
    linkExactActiveClass: "active",
    scrollBehavior() {
        return { x: 0, y: 0 };
    }
})

// ==========check login or not==========
function authGuard(to, from, next) {
    if (Admin.loggedIn()) {
        if (to.meta.nav) {
            const obj = { 'route': to.name, 'title': to.meta.title ? to.meta.title : to.name }
            breadcrumbs.dispatch("addMenu", obj);
        }
        next();
    } else {
        next({ name: 'admin.loginme' });
    }
}

export default router
