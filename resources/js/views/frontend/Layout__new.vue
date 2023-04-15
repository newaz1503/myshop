<template>
    <div class="layout-wrapper">
        <Header/>
        <main class="main-body">
            <router-view></router-view>
        </main>
        <Footer/>
        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="cart-list-sidebar">
            <div class="d-flex align-items-center bg-color bg-gradient p-3 offcanvas-header">
                <div class="row m-0 p-0">
                    <div class="col-sm">
                        <div>
                            <h5 class="fs-14 mb-0 text-white">Your Cart ({{$store.state.cartCount}})</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto text-end">
                        <router-link :to="{name:'products'}"
                                     class="link-primary text-decoration-underline text-white">Continue Shopping
                        </router-link>
                    </div>
                </div>

                <button type="button" class="btn-close btn-close-white ms-auto" id="customizerclose-btn"
                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <template v-if="$store.state.cart && Object.keys($store.state.cart).length > 0">
                    <div class="card product mb-2" v-for="(cart,index) in $store.state.cart" :key="index">
                        <div class="card-body py-2">
                            <div class="row gy-3">
                                <div class="col-lg-2 px-0 col-sm-auto">
                                    <div class="bg-light rounded p-1">
                                        <img :src="cart.featured_image" alt="" class="img-fluid d-block">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm">
                                    <div class="col-lg-12">
                                        <h5 class="fs-14 text-truncate">
                                            <router-link :to="{name:'productDetails',params:{slug:cart.slug }}"
                                                         class="text-dark">{{ cart.name }}
                                            </router-link>
                                        </h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6 pt-2">
                                                <div class="input-step">
                                                    <button v-if="cart.quantity > 1" @click="decrement(cart)"
                                                            type="button"
                                                            class="minus">–
                                                    </button>
                                                    <button v-else disabled="disabled" type="button" class="minus">–
                                                    </button>
                                                    <input type="number" disabled class="product-quantity"
                                                           :value="cart.quantity" min="0" max="100">
                                                    <button @click="increment(cart)" type="button" class="plus">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 pt-1">
                                                <div class="text-lg-end">
                                                    <p class="text-muted mb-1">Item Price:</p>
                                                    <h5 class="fs-13">{{ $root.global.currency_symbol }} <span
                                                        class="product-price">{{ cart.sale_price | currency }}</span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card body -->
                        <div class="card-footer">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <div class="d-flex flex-wrap my-n1">
                                        <div>
                                            <a href="javascript:" @click="removeFromCart(cart)"
                                               class="d-block text-body p-1 px-2"><i
                                                class="ri-delete-bin-fill text-muted align-bottom me-1"></i> Remove</a>
                                        </div>
                                        <div>
                                            <a href="#" class="d-block text-body p-1 px-2"><i
                                                class="ri-star-fill text-muted align-bottom me-1"></i> Add Wishlist</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <div>Total :</div>
                                        <h5 class="fs-14 mb-0">{{ $root.global.currency_symbol }} <span
                                            class="product-line-price">{{ cart.total_price | currency }}</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card footer -->
                    </div>
                </template>

            </div>
            <div class="offcanvas-footer border-top p-3 text-center">
                <div class="row">
                    <div class="col-6">
                        <button disabled="true" type="button" class="btn btn-light w-100" id="reset-layout">
                            <b>Total</b> {{ $root.global.currency_symbol }} {{ grandTotal | currency }}
                        </button>
                    </div>
                    <div class="col-6">
                        <router-link :to="{name:'checkout'}" class="btn bg-color w-100 text-white">
                            Checkout <i class="mdi mdi-arrow-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="offer-popup" size="lg" hide-header-close hide-footer>
            <div class="popup_content">
                <div class="popup_img_box">
                    <a href="">
                        <img :src="$root.baseurl+'/frontend/images/campaign/1.png'" alt="">
                    </a>
                    <div class="close2" id="close2" @click="$bvModal.hide('offer-popup')">
                        <i class="ri-close-line social_icon2"></i>
                    </div>
                </div>
            </div>
        </b-modal>

        <!--pop-up box-1-->
        <transition enter-active-class="animate__animated  animate__fadeInUp"
                    leave-active-class="animate__animated  animate__fadeOutDown">
            <div class="popup_box" v-show="socialLoginPopup">
                <div class="popup_content">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-none d-sm-block d-xs-block"></div>
                        <h2 class="pop_head">Welcome to {{$root.global.app_name}}</h2>
                        <div class="closeIcon"><i class="bx bx-x close_icon_1" @click="socialLoginPopup = false"></i>
                        </div>
                    </div>
                    <p class="pop_desc">Sign in to see personalized deals</p>
                    <div class="pop_social_box">
                        <div>
                            <router-link :to="{name: 'login'}" class="pop_btn">Sign in</router-link>
                        </div>
                        <div>Or</div>
                        <div>
                            <ul class="pop_social">
                                <li><a :href="$root.baseurl+'/login/facebook'" target="_blank"><i
                                    class="ri-facebook-line fb_icon"></i></a></li>
                                <li><a :href="$root.baseurl+'/login/twitter'" target="_blank"><i
                                    class="ri-twitter-line tw_icon"></i></a></li>
                                <li><a :href="$root.baseurl+'/login/google'" target="_blank"><i
                                    class="ri-google-line gl_icon"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        
    </div>
</template>

<script>
    import Footer from "./elements/Footer";
    import Header from "./elements/Header";

    export default {
        components: {Header, Footer},
        data() {
            return {
                socialLoginPopup: false,
            }
        },

        mounted() {
            setTimeout(() => {
                this.socialLoginPopup = true;
            }, 6000);
            // this.$bvModal.show('offer-popup')
        }
    };
</script>
<style>
    main.main-body {
        min-height: 30rem;
    }
    .form-group.has-error .help-block {
        color: #f44336;
    }
</style>
