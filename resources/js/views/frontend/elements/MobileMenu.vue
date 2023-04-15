<template>
    <div class="">
        <header id="page-topbar" class="topbar-shadow mobile_app_bar d-xl-none d-md-none d-lg-none">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <router-link :to="{name: 'home'}"
                                     class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                            <i class="bx bx-home-alt fs-22"></i>
                        </router-link>

                        <div class="btn-group dropup">
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                    id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-reference="parent">
                                <i class="bx bx-category-alt fs-22"></i>
                            </button>
                            <div class="dropdown-menu category-dropup_menu p-0" aria-labelledby="dropdownMenuReference"
                                 id="mobile_category_bar">
                                <div class="card p-0 m-0 shadow-none border-0">
                                    <div class="card-body bg-white">
                                        <div class="category-search mb-3">
                                            <input @keyup="allcategories" v-model="category_search_keyword"
                                                   class="form-control" type="text" placeholder="Search..">
                                        </div>
                                        <ul class="list-unstyled mb-0 filter-list categories-list"
                                            v-if="categories && Object.keys(categories).length > 0">
                                            <li v-for="(category, ckey) in categories" :key="ckey">
                                                <router-link :to="{name:'products', query:{category:category.slug}}"
                                                             :class="search.category_id == category.id ? 'active':''"
                                                             class="d-flex py-1 align-items-center"
                                                >
                                                    <div class="flex-grow-1 gap-2 d-flex align-items-center">
                                                        <img :src="category.image" height="20" width="20" alt="">
                                                        <h5 class="fs-13 mb-0 listname">{{ category.title }}</h5>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <span class="badge bg-light text-muted">{{ category.productCount }}</span>
                                                    </div>
                                                </router-link>
                                                <ul class="mb-0 ps-4 child-category"
                                                    v-if="category && Object.keys(category.child_categories).length > 0">
                                                    <li v-for="(childCat,chindex) in category.child_categories"
                                                        :key="chindex">
                                                        <router-link
                                                            :to="{name:'products', query:{category:childCat.slug}}"
                                                            class="d-flex py-1 align-items-center"
                                                        >
                                                            <div class="flex-grow-1">
                                                                <h5 class="fs-13 mb-0 listname">{{ childCat.title
                                                                    }}</h5>
                                                            </div>
                                                            <div class="flex-shrink-0 ms-2">
                                                                <span class="badge bg-light text-muted">{{ childCat.productCount }}</span>
                                                            </div>
                                                        </router-link>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <!--                                        <ul class="list-group">-->
                                        <!--                                            <li class="list-group-item border-dashed border" aria-disabled="true">-->
                                        <!--                                                <div class="d-flex align-items-center">-->
                                        <!--                                                    <div class="flex-grow-1 ms-2">-->
                                        <!--                                                        Browse Category-->
                                        <!--                                                    </div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </li>-->
                                        <!--                                            <template v-for="category in categories">-->
                                        <!--                                                <router-link :to="{name:'products', query:{category:category.slug}}">-->
                                        <!--                                                    <li class="list-group-item disabled" aria-disabled="true">-->
                                        <!--                                                        <div class="d-flex align-items-center">-->
                                        <!--                                                            <div class="flex-shrink-0">-->
                                        <!--                                                                <img v-if="category.image" :src="category.image" alt=""-->
                                        <!--                                                                     class="avatar-xs rounded">-->
                                        <!--                                                            </div>-->
                                        <!--                                                            <div class="flex-grow-1 ms-2" v-if="category.title">-->
                                        <!--                                                                {{ category.title }}-->
                                        <!--                                                            </div>-->
                                        <!--                                                        </div>-->
                                        <!--                                                    </li>-->
                                        <!--                                                </router-link>-->

                                        <!--                                            </template>-->


                                        <!--                                        </ul>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- App Search-->
                        <div class="global-search-container">
                            <div class="topbar-head-dropdown header-item mobile-search-box">
                                <button @click="showSearchDropdown = !showSearchDropdown" type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                        id="page-header-search-dropdown">
                                    <i class="bx bx-search fs-22"></i>
                                </button>
                            </div>
                            <div class="search-dropdown" v-show="showSearchDropdown">
                                <form @submit.prevent="globalSerach" class="w-100" id="mobile_search_form">
                                    <div class="input-group header_search  ps-2 pe-2 pe-sm-0 pe-xs-0">
                                        <input @keyup="globalSerach" type="text" v-model="search.keyword" placeholder="Search for products, brands and more...
                            " class="form-control bg-transparent p-2 border-0 border-round"
                                               aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button @click="voiceRecorder" type="button"
                                                class="border-0 bg-transparent px-3 py-1" data-bs-toggle="offcanvas"
                                                data-bs-target="#mobileOffcanvasTop" aria-controls="mobileOffcanvasTop">
                                            <i class="mdi mdi-microphone fs-22"></i>
                                        </button>
                                        <button class="btn btn-outline-success border-0  bg-color text-white m-sm-0"
                                                type="submit"
                                                id="button-addon2"><i
                                            class="mdi mdi-magnify search-widget-icon"></i><span
                                            class="d-sm-none d-xxl-block d-xl-block"> Search</span>
                                        </button>
                                    </div>
                                </form>
                                <transition enter-active-class="animate__animated animate__fadeInDown" leave-active-class="animate__animated  animate__fadeOutUp">
                                    <div class="offcanvas offcanvas-top" v-show="voiceRecoderShow" tabindex="-1" id="mobileOffcanvasTop" aria-labelledby="offcanvasTopLabel">
                                        <div class="offcanvas-header text-end pb-0">
                                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body pt-0">
                                            <div class="row h-100 justify-content-center align-items-center">
                                                <div class="col-lg-2 col-6">
                                                    <h4>Speak now</h4>
                                                </div>
                                                <div class="col-lg-2 col-6">
                                                    <div class="search-voice">
                                                        <i class="mdi mdi-microphone align-middle"></i>
                                                        <span class="voice-wave"></span>
                                                        <span class="voice-wave"></span>
                                                        <span class="voice-wave"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                                <div class="search-preview" v-if="search.keyword != '' && search.showSearchBox">
                                    <div class="text-end">
                                        <a href="javascript:" @click="search.showSearchBox = false"
                                           class="btn btn-sm btn-danger m-2"><i class="bx bx-x"></i></a>
                                    </div>
                                    <ul v-if="Object.keys(search.searchItems).length > 0">
                                        <li v-for="(item, key) in search.searchItems" :key="key">
                                            <router-link :to="{ name: 'productDetails', params:{slug:item.slug }}"
                                                         class="item">
                                                <img :src="item.featured_image" alt="" class="image">
                                                <h4>{{ item.name }}</h4>
                                            </router-link>
                                        </li>
                                    </ul>
                                    <div v-else class="h-100">
                                        <template v-if="search.searching">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <div class="spinner-border text-dark" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="empty">
                                                <i class="ri-search-2-line"></i>
                                                <h4> No Data Available! </h4>
                                            </div>
                                        </template>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="btn-group dropup">
                            <button type="button" class="btn dropdown-toggle position-relative" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bx bx-shopping-bag fs-22"></i>
                                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-color">
                                    {{ $store.state.cartCount }}
                                </span>
                            </button>
                            <div class="dropdown-menu card-dropup_menu" id="mobile_cart_bar">
                                <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold"> My Cart</h6>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-color fs-13"><span
                                                class="cartitem-badge">{{ $store.state.cartCount }}</span>
                                                items</span>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="" class="overflow-scroll data-simplebar">
                                    <div class="p-2">
                                        <!-- Empty Cart -->
                                        <template
                                            v-if="$store.state.cart && Object.keys($store.state.cart).length <= 0">
                                            <div class="text-center empty-cart" id="empty-cart">
                                                <div class="avatar-md mx-auto my-3">
                                                    <div
                                                        class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                                        <i class='bx bx-cart'></i>
                                                    </div>
                                                </div>
                                                <h5 class="mb-3">Your Cart is Empty!</h5>
                                                <router-link :to="{name:'products'}" class="btn text-color w-md mb-3">
                                                    Shop
                                                    Now
                                                </router-link>
                                            </div>
                                        </template>
                                        <!-- Empty Cart Section Ends -->

                                        <!-- Cart items Start -->
                                        <template v-if="$store.state.cart && Object.keys($store.state.cart).length > 0">
                                            <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"
                                                 v-for="(cart,index) in $store.state.cart" :key="index">
                                                <div class="d-flex align-items-center">
                                                    <img :src="cart.featured_image"
                                                         class="me-3 rounded-circle avatar-sm p-2 bg-light"
                                                         alt="user-pic">
                                                    <div class="flex-1">
                                                        <h6 class="mt-0 mb-1 fs-14">
                                                            <router-link
                                                                :to="{name:'productDetails',params:{slug:cart.slug }}"
                                                                class="text-dark">{{ cart.name }}
                                                            </router-link>
                                                        </h6>
                                                        <div class="input-step">
                                                            <button v-if="cart.quantity > 1" @click="decrement(cart)"
                                                                    type="button"
                                                                    class="minus">–
                                                            </button>
                                                            <button v-else disabled="disabled" type="button"
                                                                    class="minus">–
                                                            </button>
                                                            <input type="number" disabled class="product-quantity"
                                                                   :value="cart.quantity" min="0" max="100">
                                                            <button @click="increment(cart)" type="button" class="plus">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="px-2">
                                                        <h5 class="m-0 fw-normal">{{ $root.global.currency_symbol }}
                                                            <span
                                                                class="cart-item-price">{{
                                                                    cart.sale_price | currency
                                                                }}</span>
                                                        </h5>
                                                    </div>
                                                    <div class="ps-2">
                                                        <button type="button"
                                                                href="javascript:" @click="removeFromCart(cart)"
                                                                class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn">
                                                            <i
                                                                class="ri-close-fill fs-16"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border"
                                     id="checkout-elem"
                                     v-if="$store.state.cart && Object.keys($store.state.cart).length > 0">
                                    <div class="d-flex justify-content-between align-items-center pb-3">
                                        <h5 class="m-0 text-muted">Total:</h5>
                                        <div class="px-2">
                                            <h5 class="m-0" id="cart-item-total"> ${{ grandTotal | currency }}</h5>
                                        </div>
                                    </div>

                                    <router-link :to="{name:'checkout'}" class="btn bg-color text-center w-100">
                                        Checkout
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group dropup" v-if="$root.userLoggedIn">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" v-if="profileInfo"
                                         :src="profileInfo.avatar"
                                         alt="Header Avatar">
                                </span>
                            </button>
                            <div class="dropdown-menu">
                                <!-- item-->
                                <h6 class="dropdown-header" v-if="profileInfo">Welcome, <br> {{ profileInfo.name }}!</h6>
                                <router-link class="dropdown-item" :to="{name: 'user.dashboard'}"><i
                                    class="mdi mdi-view-dashboard text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Dashboard</span></router-link>
                                <router-link class="dropdown-item" :to="{name: 'user.profile'}"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></router-link>


                                <a class="dropdown-item" href="javascript:" @click="logout"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        <!-- ============================================-->
        <!-- Mobile Header part start -->
        <!-- ============================================-->

        <!-- ============================================-->
        <!-- navbar part start -->
        <!-- ============================================-->
        <nav
            class="border-bottom pb-3 pt-3 bg-color   d-xxl-block d-xl-block d-lg-block d-md-block d-sm-none d-xs-none ">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-10  col-xl-10 col-lg-12 offset-xxl-1 offset-xl-2">
                        <ul class="d-flex align-items-center justify-content-center p-0 m-0">
                            <li>
                                <router-link :to="{ name: 'home' }" class="">Home</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'about-us' }" class="">About Us</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'products' }" class="">All Products</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'brands' }" class="">All Brands</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'categories' }" class="">All Categories</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'campaigns' }" class="">Campaign</router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'coupons'}" class="">Coupons</router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'faq'}" class="">FAQ</router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'contact-us'}" class="">Contact Us</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- ============================================-->
        <!-- navbar part end -->
        <!-- ============================================-->
    </div>
</template>

<script>
    export default {
        name: "MobileMenu",
        data() {
            return {
                data: {},
                cart: {
                    customer_id: 0,
                    shipping_id: null,
                    sub_total: 0,
                    product_discount: 0,
                    invoice_discount: null,
                    vat: 0,
                    tax: 0,
                    shipping_cost: null,
                    grand_total: 0,
                    total_recieve: null,
                    change: 0
                },

                profileInfo: [],
                categories: [],
                showSearchDropdown:false,
                voiceRecoderShow: false,
                topBannerHidden: false,
                search: {
                    keyword: '',
                    showSearchBox: false,
                    searching: false,
                    searchItems: []
                },
                category_search_keyword: '',
            }
        },
        watch:{
            $route: {
                handler: function (to, from) {
                    this.showSearchDropdown = false;
                },
                deep: true,
                immediate: true
            }
        },
        computed: {
            totalPrice() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.total_price;
                }
                this.cart.sub_total = total;
                return total > 0 ? total : 0;
            },
            totalProductDiscount() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.discount_amount;
                }
                this.cart.product_discount = total;
                return total > 0 ? total : 0;
            },
            totalVat() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.vat_amount;
                }
                this.cart.vat = total
                return total > 0 ? total : 0;
            },
            totalTax() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.tax_amount;
                }
                this.cart.tax = total;
                return total > 0 ? total : 0;
            },
            grandTotal() {
                const shippingCost = this.cart.shipping_cost ? this.cart.shipping_cost : 0;
                const invoiceDiscount = this.cart.invoice_discount ? this.cart.invoice_discount : 0;
                const discount = parseInt(invoiceDiscount) + parseInt(this.totalProductDiscount);
                const totalCost = parseInt(this.totalPrice) + parseInt(this.totalTax) + parseInt(this.totalVat) + parseInt(shippingCost);
                const total = totalCost - discount;
                this.cart.grand_total = total;
                return total > 0 ? total : 0;
            }
        },
        methods: {
            logout() {
                User.logout();
            },
            globalSerach() {
                this.search.searching = true;
                this.search.showSearchBox = true;
                let keyword = this.search.keyword.trim();
                axios.get('global-search', {params: {keyword: keyword}}).then(res => {
                    this.search.searchItems = res.data.product;
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    setTimeout(() => {
                        this.voiceRecoderShow = false;
                        this.search.searching = false;
                        let backdrop = document.querySelector('.offcanvas-backdrop');
                        backdrop.remove();
                    }, 200);
                })
            },
            voiceRecorder() {
                this.voiceRecoderShow = true;
                let self = this;
                if ('webkitSpeechRecognition' in window) {
                    const recognition = new webkitSpeechRecognition();
                    recognition.lang = 'en-US';
                    recognition.interimResults = false;
                    recognition.onresult = function (event) {
                        const result = event.results[event.resultIndex][0].transcript;
                        self.search.keyword = result;
                        self.globalSerach();
                    }
                    recognition.onerror = function (event) {
                        console.error('Speech recognition error:', event.error);
                    }
                    recognition.start();
                }
            },
            removeFromCart(product) {
                this.$swal.fire({
                    title: 'Are you sure to remove this item?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.commit('REMOVE_FROM_CART', product);
                        this.$store.commit('SAVE_CART')
                        this.$swal.fire('Successfuly Removed!', '', 'success')
                    }
                })
            },
            increment(product) {
                this.$store.commit('INCREMENT', product);
                this.$store.commit('SAVE_CART')
            },
            decrement(product) {
                this.$store.commit('DECREMENT', product);
                this.$store.commit('SAVE_CART')
            },
            async allcategories() {
                await axios.get('parent-categories', {params: {keyword: this.category_search_keyword}}).then(res => {
                    this.categories = res.data;
                }).catch(error => {
                    console.log(error)
                });
            }
        },


        async mounted() {
            // Get User Details
            if(this.$root.userLoggedIn){
                axios.get('user/get-profile-info').then((response) => {
                    this.profileInfo = response.data;
                }).catch((error) => {
                    console.log(error)
                })
            }

            await this.allcategories();
        }
    }

</script>

<style lang="scss">

    .data-simplebar-init {
        max-height: 320px;
    }

    .data-simplebar {
        max-height: 300px;
    }
    .search-voice .voice-wave{
        background-color: var(--vz-primary) !important;
    }
    .search-preview {
        width: 100%;
        position: unset;
        height: 400px;
        background: white;
        box-shadow: unset;
        top: 60px;
        z-index: 1;
        overflow: hidden;
        overflow-y: scroll;
        ul {
            margin: 0;
            padding: 10px;

            li {
                .item {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 5px 5px;
                    border-bottom: 1px solid #ececec;

                    img.image {
                        height: 45px;
                        width: 45px;
                    }

                    h4 {
                        font-size: 13px;
                        height: 34px;
                        overflow: hidden;
                    }
                }
            }
        }

        .empty {
            text-align: center;
            height: 500px;
            padding: 124px 0;
            display: flex;
            flex-direction: column;
            align-items: center;

            i {
                font-size: 40px;
                color: #4444;
            }

            h4 {
                color: #4444;
            }
        }
    }

    .list-unstyled.categories-list {
        height: 326px;
        overflow: hidden;
        overflow-y: scroll;
    }

    .child-category {
        list-style: circle;
    }
    .search-dropdown{
        position: fixed;
        width: 100%;
        height: 480px;
        top: 0;
        left: 0;
        background: #fff;
        padding: 10px;
        .input-group.header_search {
            border: 1px solid var(--vz-primary);
            margin: 13px auto;
            width: 100%;
            border-radius: 50px;
            overflow: hidden;
        }
    }
    .navbar-header .topbar-head-dropdown .dropdown-menu#mobile_search_bar.show{
        top: 0 !important;
    }
</style>
