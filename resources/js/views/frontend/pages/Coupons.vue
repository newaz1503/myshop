<template>
    <div class="coupon-section my-4">
        <div class="container">
            <div class="row" v-if="coupons && Object.keys(coupons).length > 0">
                <div class="col-lg-12 my-2" v-for="(coupon, key) in coupons" :key="key">
                    <div class="border border-dashed rounded bg-white p-2">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 text-center">
                                <div class="border border-dashed border-1 rounded border-color p-2">
                                    <h1 class="text-color fw-bold">
                                        {{ coupon.discount_amount }}{{ coupon.discount_type == 'percentage' ? '%': $root.global.currency_symbol }} OFF
                                    </h1>
                                </div>

                            </div>
                            <div class="col-lg-4 text-center">
                                <h2 class="text-dark">{{ coupon.title }}</h2>
                                <p class="text-muted">Expire On : {{ coupon.expire_date | formatDate }}</p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="border border-dashed border-1 rounded border-color p-3">
                                    <span class="text-color fs-15 text-uppercase fw-bold px-2">
                                        Coupon Code :
                                    </span>
                                    <span class="bg-color fs-15 text-uppercase fw-bold px-4 py-2 text-white">
                                        {{ coupon.code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 px-2" v-if="coupon.products && Object.keys(coupon.products).length > 0">
                        <div class="col-lg-2 px-2 " v-for="(product,index) in coupon.products" :key="index">
                            <div class="card shadow-sm card-height-100 product-component ribbon-box">
                                <template v-if="product && Object.keys(product).length > 0">
                                    <div class="card-body pb-0">
                                        <div class="ribbon-two ribbon-two-danger">
                                            <span>{{ `${coupon.discount_amount}${coupon.discount_type == 'percentage' ? '%': $root.global.currency_symbol} OFF` }}</span>
                                        </div>
                                        <router-link :to="{name:'productDetails',params:{ slug:product.slug }}">
                                            <img :src="product.featured_image" alt="" class="img-fluid image w-100">
                                            <h5 class="mb-0 title">{{ product.name }}</h5>
                                        </router-link>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="fs-16 align-middle text-warning">
                                                    <span :class="product.rating >= 1 ? 'ri-star-fill':'ri-star-line'"></span>
                                                    <span :class="product.rating >= 2 ? 'ri-star-fill':'ri-star-line'"></span>
                                                    <span :class="product.rating >= 3 ? 'ri-star-fill':'ri-star-line'"></span>
                                                    <span :class="product.rating >= 4 ? 'ri-star-fill':'ri-star-line'"></span>
                                                    <span :class="product.rating >= 5 ? 'ri-star-fill':'ri-star-line'"></span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h6 class="mb-0">({{ product.rating }})</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 p-2">
                                        <div class="row align-items-center gy-3">
                                            <div class="col-sm">
                                                <div class="d-block">
                                                    <div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-color fs-14 mb-0 main-col d-flex">
                                        <span class="text-decoration-line-through text-muted fs-13">
                                            {{ $root.global.currency_symbol }}{{product.sale_price.toFixed(2) }}
                                        </span>
                                                                <span class="fw-bold text-muted px-2">-</span>
                                                                <span>
                                                                    {{ $root.global.currency_symbol }}{{ dicountedPrice(product.sale_price,coupon.discount_amount,coupon.discount_type) }}
                                                                </span>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div></div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    class="d-flex align-items-center gap-2 text-muted justify-content-between product_card_footer">
                                                    <router-link  :to="{name:'productDetails',params:{ slug:product.slug }}" title="Add to cart"
                                                                  class=" d-block cart_button w-100 btn bg-color btn-sm text-white">
                                                        <i class="mdi mdi-shopping"></i> Buy Now
                                                    </router-link>
                                                    <a @click="addToWishlist(product.id)" href="javascript:" title="Wishlist"
                                                       class="d-block border-color btn btn-sm wishlist">
                                                        <i class="text-color bx bx-heart align-bottom me-0 fs-15"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div v-else class="row pt-3">
                <div class="col-lg-12 bg-white" v-if="!is_loading">
                    <div class="row justify-content-center py-5">
                        <div class="col-lg-6 text-center">
                            <img :src="$root.baseurl+'/public/frontend/images/not-found.jpg'" class="img-fluid rounded" alt="" width="220" height="120">
                            <h5>No Coupon Available!</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Coupons",
        data(){
            return{
                coupons:[]
            }
        },
        methods:{
            addToCart(product) {
                this.$store.commit('ADD_TO_CART', product);
                this.$store.commit('SAVE_CART');
                this.notification('Product has been added in your cart!', 'success');
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
            dicountedPrice(salePrice,couponPrice,discountType){
                if(discountType == 'percentage'){
                    return (salePrice - salePrice * couponPrice / 100).toFixed(2);
                }else{
                    return salePrice - couponPrice;
                }
            }
        },
        created() {
            axios.get('coupons').then(res => {
                this.coupons = res.data;
            }).catch(error => {
                console.log(error)
            })
        }
    }
</script>

<style scoped>

</style>
