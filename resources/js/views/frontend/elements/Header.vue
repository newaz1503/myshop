<template>
    <div class="">
        <div  class="promotional_header" v-if="$root.global.top_header_banner && !topBannerHidden">
            <router-link :to="{name:'campaigns'}">
                <img :src="$root.global.top_header_banner"
                     class="img-fluid w-100"/>
            </router-link>
            <button class="close-button" @click="hideTopBanner">
                <i class="mdi mdi-close"></i>
            </button>
        </div>
        <!-- ============================================-->
        <!-- navbar part end -->
        <!-- ============================================-->
        <TopHeader></TopHeader>
        <!-- ============================================-->
        <!-- Middle Header start -->
        <!-- ============================================-->
        <div id="search" class="py-2 border-bottom bg-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3 col-xs-6 col-md-2 col-sm-6 d-flex align-items-center">
                        <router-link :to="{ name: 'home' }">
                            <img class="img-fluid" :src="$root.global.logo" alt="">
                        </router-link>
                    </div>

                    <div
                        class="col-xl-5  col-lg-4 col-md-5 col-sm-6 d-sm-none search-input-col d-flex align-items-center justify-content-center d-md-block d-lg-block position-relative">
                        <form @submit.prevent="globalSerach" class="w-100">
                            <div class="input-group header_search  ps-2 pe-2 pe-sm-0 pe-xs-0">
                                <input @keyup="globalSerach" type="text" v-model="search.keyword" placeholder="Search for products, brands and more...
                            " class="form-control bg-transparent p-2 border-0 border-round"
                                       aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button @click="voiceRecorder" type="button" class="border-0 bg-transparent px-3 py-1"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                                    <i class="mdi mdi-microphone fs-22"></i>
                                </button>
                                <button class="btn btn-outline-success border-0  bg-color text-white m-sm-0"
                                        type="submit"
                                        id="button-addon2"><i class="mdi mdi-magnify search-widget-icon"></i><span
                                    class="d-sm-none d-xxl-block d-xl-block"> Search</span>
                                </button>
                            </div>
                        </form>
                        <div class="search-preview" v-if="search.keyword != '' && search.showSearchBox">
                            <div class="text-end">
                                <a href="javascript:" @click="search.showSearchBox = false" class="btn btn-sm btn-danger m-2"><i class="bx bx-x"></i></a>
                            </div>
                            <ul v-if="Object.keys(search.searchItems).length > 0">
                                <li v-for="(item, key) in search.searchItems" :key="key">
                                    <router-link :to="{ name: 'productDetails', params:{slug:item.slug }}" class="item">
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
                    <div
                        class="col-xl-4 col-lg-5 col-md-5 col-sm-6 d-flex align-items-center justify-content-end login_register_conent  col-xs-6">
                        <div class="d_sm_none">
                            <div class="card mb-1 d-inline-block shadow-none  d-xxl-inline-block d-xs-none">
                                <div class="card-body p-0">
                                    <a class="d-flex align-items-center">
                                        <div class="flex-shrink-0">

                                            <button type="button"
                                                    class="btn btn-icon btn-topbar rounded-circle bg-body">
                                                <i class="ri-user-line text-white"></i>
                                            </button>
                                        </div>
                                        <div class="flex-grow-1 header_accont">
                                            <p class="text-muted mb-0 cursor-pointer">
                                                <template v-if="$root.userLoggedIn">
                                                    <span class="ps-2 d-flex-column">
                                                        <h6 class="fs-12 text-muted mb-1">Hi, </h6>
                                                            <router-link :to="{ name: 'user.dashboard' }">
                                                                {{ username }}
                                                            </router-link>
                                                    </span>
                                                </template>
                                                <template v-else>
                                                    <div class="user_bottom_par fs-12 custom_font_weight">
                                                        <h6 class="fs-12 mb-1">Create Account </h6>
                                                        <span class="">
                                                            <router-link :to="{ name: 'login' }">Login</router-link>
                                                        </span>
                                                        <span class="ps-1">Or</span>
                                                        <span class="ps-1">
                                                            <router-link
                                                                :to="{ name: 'register' }">Register</router-link>
                                                        </span>
                                                    </div>
                                                </template>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div
                                class="card mb-1 d-inline-block d-xs-none d_sm_none custom_font_weight shadow-none d-xxl-inline-block d-xl-inline-block d-lg-inine-block"
                                data-bs-toggle="offcanvas" data-bs-target="#cart-list-sidebar"
                                aria-controls="cart-list-sidebar">
                                <div class="card-body p-0">
                                    <a class="d-flex align-items-center" href="javascript:">
                                        <div class="flex-shrink-0">
                                            <button type="button"
                                                    class="btn btn-icon btn-topbar rounded-circle bg-body">
                                                <i class="bx bx-shopping-bag fs-14 text-white"></i>
                                            </button>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-12 mb-1"> View Cart({{ $store.state.cartCount
                                                }}) </h6>
                                            <p class="mb-0" v-if="totalPrice > 0">
                                                {{ $root.global.currency_symbol }}{{ totalPrice | currency }}
                                            </p>
                                            <p class="mb-0" v-else>
                                                {{ $root.global.currency_symbol }} 00.0
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="mobile_side_bar"
                             class="d-xxl-none d-xl-none d-lg-none d-md-none d-sm-block d-xs-block">
                            <div class="hstack flex-wrap gap-2">
                                <button class="btn btn-light" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                    <i class=" ri-align-justify"></i>
                                </button>
                            </div>

                            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                                 aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header custom_mobile_header">
                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                                        <router-link :to="{ name: 'home' }">
                                            <img class="img-fluid" :src="$root.global.logo" alt="">
                                        </router-link>
                                    </h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body pt-3">
                                    <ul class="p-0 m-0 mobile_nav_bar">
                                        <li>
                                            <a :href="$root.baseurl+'/home'" class="">Home</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/about-us'" class="">About Us</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/products'" class="">All Products</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/brands'" class="">All Brands</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/categories'" class="">All Categories</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/campaigns'" class="">Campaign</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/coupons'" class="">Coupons</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/faq'" class="">FAQ</a>
                                        </li>
                                        <li>
                                            <a :href="$root.baseurl+'/contact-us'" class="">Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <transition enter-active-class="animate__animated animate__fadeInDown" leave-active-class="animate__animated  animate__fadeOutUp">
            <div class="offcanvas offcanvas-top" v-show="voiceRecoderShow" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
                <div class="offcanvas-header text-end pb-0">
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body pt-0">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-lg-2">
                            <h4>Speak now</h4>
                        </div>
                        <div class="col-lg-2">
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


        <!-- ============================================-->
        <!-- Header part end -->
        <!-- ============================================-->

        <MobileMenu></MobileMenu>
    </div>
</template>

<script>
    import TopHeader from "./TopHeader";
    import MobileMenu from "./MobileMenu";
    export default {
        name: "Header",
        components: {TopHeader,MobileMenu},
        data() {
            return {
                voiceRecoderShow:false,
                topBannerHidden: false,
                search: {
                    keyword: '',
                    showSearchBox: false,
                    searching: false,
                    searchItems: []
                },
            }
        },
        watch:{
            $route: {
                handler(){
                    this.search.showSearchBox = false;
                },
                deep: true,
                immediate: true
            }
        },
        computed: {
            username() {
                return User.name()
            },
            totalPrice() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.total_price;
                }
                return total > 0 ? total : 0;
            },
        },
        methods: {
            voiceRecorder(){
                this.voiceRecoderShow = true;
                let self  = this;
                if ('webkitSpeechRecognition' in window) {
                    const recognition = new webkitSpeechRecognition();
                    recognition.lang = 'en-US';
                    recognition.interimResults = false;
                    recognition.onresult = function(event) {
                        const result = event.results[event.resultIndex][0].transcript;
                        self.search.keyword = result;
                        self.globalSerach();
                    }
                    recognition.onerror = function(event) {
                        console.error('Speech recognition error:', event.error);
                    }
                    recognition.start();
                }
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
            logout() {
                User.logout();
            },
            hideTopBanner() {
                this.topBannerHidden = true;
                sessionStorage.setItem('topBannerHidden', 'true');
            },
        },
        mounted() {
            if (sessionStorage.getItem('topBannerHidden') === 'true') {
                this.topBannerHidden = true;
            }
        }
    }
</script>
<style lang="scss" scoped>
    .search-voice .voice-wave{
        background-color: var(--vz-primary) !important;
    }
    .dropdown-menu{
        position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 58px);
    }
    .search-preview {
        width: 100%;
        position: absolute;
        height: 500px;
        background: white;
        box-shadow: 0 4px 5px #4444;
        top: 60px;
        z-index: 1;
        overflow-y: auto;
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
    .promotional_header{
        height: 50px;
        position: relative;
        img{
            height: 100%;
            object-fit: cover;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fff4;
            border: none;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            border-radius: 5px;
        }
    }
    .bg-body{
        background-color: var(--vz-primary) !important;
    }
    .top-header-color {
        color: var(--vz-primary) !important;
    }
    .custom_font_weight{
        font-weight: 500 !important;
    }
    #search .header_search button{
        align-items: center !important;
        font-size: 15px !important;
    }

</style>
