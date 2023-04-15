<template>
    <div class="layout-wrapper">
        <Header/>
        <router-view></router-view>
        <Footer/>
        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="cart-list-sidebar" data-bs-backdrop="static">
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

                <button type="button" class="btn-close btn-close-white ms-auto text-white" id="customizerclose-btn"
                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body px-1">
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
                                                    <button v-if="cart.quantity > 1" @click="decrement(cart)" type="button"
                                                            class="minus">–
                                                    </button>
                                                    <button v-else disabled="disabled" type="button" class="minus">–</button>
                                                    <input type="number" disabled class="product-quantity"
                                                           :value="cart.quantity" min="0" max="100">
                                                    <button @click="increment(cart)" type="button" class="plus">+</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 pt-1">
                                                <div class="text-lg-end">
                                                    <p class="text-muted mb-1">Item Price:</p>
                                                    <h5 class="fs-13">{{ $root.global.currency_symbol }} <span
                                                        class="product-price">{{ cart.sale_price | currency }}</span></h5>
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
                                            <a href="javascript:" @click="removeFromCart(cart)" class="d-block text-body p-1 px-2">
                                                <i class="mdi mdi-trash-can text-muted align-bottom me-1"></i>
                                                Remove
                                            </a>
                                        </div>
                                        <div>
                                            <a href="javascript:" @click="addToWishlist(cart.id)" class="d-block text-body p-1 px-2"><i
                                                class="mdi mdi-heart text-muted align-bottom me-1"></i>
                                                Add Wishlist
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <div>Total :</div>
                                        <h5  class="fs-14 mb-0">{{ $root.global.currency_symbol }}
                                            <span class="product-line-price" v-if="cart.total_price > 0">
                                                {{ cart.total_price | currency }}
                                            </span>
                                            <span class="product-line-price" v-else>
                                                0.00
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card footer -->
                    </div>
                </template>
                <template v-else>
                    <div class="col-lg-12 bg-white" v-if="!is_loading">
                        <div class="row justify-content-center py-5">
                            <div class="col-lg-8 text-center">
                                <img :src="$root.baseurl+'/public/frontend/images/empty-cart.png'" alt="" width="240">
                                <h5 class="text-center">Cart is empty</h5>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
            <div class="offcanvas-footer border-top p-3 text-center">
                <div class="row">
                    <div class="col-6">
                        <button disabled="true" type="button" v-if="" class="btn btn-light w-100" id="reset-layout">
                            <b>Total</b> {{ $root.global.currency_symbol }}<template v-if="grandTotal > 0">{{ grandTotal | currency }}</template><template v-else>00.0</template>
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
        <div id="bottom_fixed_bar" class="position-fixed bg-color d-md-block d-sm-none d-xs-none d-lg-block d-xl-block d-xxl-block">
            <ul class="">
                        <li>
                        <router-link :to="{ name: 'campaigns' }" class="ps-5"><i class=" bx bx-gift"></i></router-link>
                    </li>

                    <li>
                        <router-link :to="{ name: 'user.orders' }" class="ps-5"> <i class="bx bx-history"></i></router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'user.wisthlist' }" class="ps-5"> <i class="bx bx-heart"></i></router-link>
                    </li>

                    <li>
                        <a data-bs-toggle="offcanvas" data-bs-target="#cart-list-sidebar" class="ps-5"> <i class="bx bx-cart-alt"></i></a>
                    </li>
                    <li class="social_icon">
                        <a class="ps-5 active router-link-active" href="javascript:void(0)"><i class=" bx bx-share-alt"></i></a>
                        <div class="social_hover_content">
                            <ul class=" ">
                                <li><a class="dropdown-item text-dark" :href="`https://www.facebook.com/sharer/sharer.php?u=${$root.baseurl}`"><i class=" ri-facebook-circle-fill"></i></a></li>
                                <li><a class="dropdown-item text-dark" :href="`https://twitter.com/share?url=${$root.baseurl}&text=''via='text'`"><i class="ri-twitter-fill"></i></a></li>
                                <li><a class="dropdown-item text-dark" :href="`https://www.linkedin.com/shareArticle?url=${$root.baseurl}&title=<TITLE>&summary=<SUMMARY>&source=${$root.baseurl}`"><i class=" ri-linkedin-box-fill"></i></a></li>
                                <li><a class="dropdown-item text-dark" :href="`https://www.instagram.com/sharer.php?u=${$root.baseurl}`"><i class="
 ri-instagram-fill"></i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
        </div>
        <div id="offer_fixed_bar" v-if="$root.global.gif_banner" class="position-fixed bg-white d-md-block d-sm-none d-xs-none d-lg-block d-xl-block d-xxl-block">
            <router-link v-if="$root.global.popup_page_url && $root.global.gif_banner" :to="$root.global.popup_page_url">
                <img :src="$root.global.gif_banner" class="img-fluid"/>
            </router-link>
        </div>

       <b-modal id="offer-popup" class="a" size="lg" hide-header-close hide-footer>
            <div class="popup_content">
                <div class="popup_img_box">
                    <router-link v-if="$root.global.popup_page_url && $root.global.popup_banner" :to="$root.global.popup_page_url" >
                        <img :src="$root.global.popup_banner" alt="">
                    </router-link>
                    <div class="close2" id="close2" @click="$bvModal.hide('offer-popup')">
                        <i class="ri-close-line social_icon2"></i>
                    </div>
                </div>
            </div>
        </b-modal>
        <!--pop-up box-1-->
        <transition enter-active-class="animate__animated  animate__fadeInUp"
                    leave-active-class="animate__animated  animate__fadeOutDown">
            <div class="popup_box login_or_registration_suggest" v-show="socialLoginPopup">
                <div class="popup_content">
                    <div class="d-flex align-items-center justify-content-between">
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
        data(){
            return{
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
                socialLoginPopup: false,
                is_loading: false,
            }
        },
        watch:{
            $route: {
                handler(){
                    this.$bvModal.hide('offer-popup')
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
            grandTotal() {
                const  total =  parseInt(this.totalPrice);
                this.cart.grand_total = total;
                return total > 0 ? total : 0;
            }
        },
        methods: {
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
            addToWishlist(id) {
                axios.post('user/addToWishlist/' + id).then((response) => {
                    if (response) {
                        if (response.data.is_login == false) {
                            this.notification("You Need to Login First !!!", "error");
                            this.$router.push({name: 'login'});
                        }
                        if (response.data.success == true) {
                            this.notification("Product Added Successfully !!!", "success");
                        }
                        if (response.data.exists == true) {
                            this.notification("Product Already Exists !!!", "error");
                        }
                    }
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.notification("You Are Unauthorized, Need to Login First !!!", "error");
                        this.$router.push({name: 'login'});
                    }
                })
            },
        },
        mounted() {
            setTimeout(() => {
                if (this.$root.userLoggedIn == false){
                    this.socialLoginPopup = true;
                }
            }, 6000);
            setTimeout(() => {
                if (this.$root.global.is_show_popup && this.$route.name == 'home'){
                    this.$bvModal.show('offer-popup')
                }
            },2000)
        }
    };
</script>
<style scoped>
    .form-group.has-error .help-block {
        color: #f44336;
    }
    .btn-close{
        opacity: 1 !important;
    }
</style>
