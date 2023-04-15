<template>
    <div class="card shadow-sm card-height-100 product-component"
         :class="label ? ' ribbon-box':''">
        <template v-if="product && Object.keys(product).length > 0">
            <div class="card-body pb-0">
                <div v-if="label" class="ribbon-two ribbon-two-danger">
                    <span>{{ labelText }}</span>
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
                                            {{ $root.global.currency_symbol }}{{product.sale_price | currency }}
                                        </span>
                                        <span class="fw-bold text-muted px-2">-</span>
                                        <span> {{ $root.global.currency_symbol }}{{ product.dicounted_price | currency }}</span>
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
        <template v-else>
            <div class="placeholder placeholder-image placeholder-wave"></div>
            <div class="card-body pb-0">
                <h5 class="card-title placeholder-glow">
                    <span class="placeholder col-6"></span>
                </h5>
                <p class="card-text placeholder-glow">
                    <span class="placeholder col-7"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-6"></span>
                </p>
            </div>
            <div class="card-footer">
                <h6 class="card-title placeholder-glow">
                    <span class="placeholder col-12"></span>
                </h6>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: "Product",
        props: {
            product: Object,
            label: {
                type: Boolean,
                default: false
            },
            labelText: {
                default: null,
                type: String
            },
        },
        data() {
            return {
                productDetails: {}
            }
        },
        methods: {
            addToCart(product) {
                this.$store.commit('ADD_TO_CART', product);
                this.$store.commit('SAVE_CART');
                this.notification('Product has been added in your cart!', 'success');
            },
            removeProduct(product) {
                this.$store.commit('REMOVE_FROM_CART', product);
                this.$store.commit('SAVE_CART')
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
                            this.notification("Product Added to Wishlist Successfully !!!", "success");
                        }
                        if (response.data.exists == true) {
                            this.notification("Product Already Exists in Wishlist !!!", "error");
                        }
                    }
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.notification("You Are Unauthorized, Need to Login First !!!", "error");
                        this.$router.push({name: 'login'});
                    }
                })
            },
        }
    }
</script>

<style lang="scss">
    .placeholder.placeholder-image {
        height: 145px;
        border-radius: 5px 5px 0 0;
    }

    .product-component {
        .title {
            height: 40px;
            overflow: hidden;
            padding: 6px 0;
            font-size: 14px;
        }
    }

    .card-footer {
        a {
            padding: 3px;
        }

        .wishlist {
            padding: 3px 5px;
        }
    }
</style>
