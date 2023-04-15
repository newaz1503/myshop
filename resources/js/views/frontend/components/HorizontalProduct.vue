<template>
    <div class="card shadow-sm card-height-100 product-component">
        <template v-if="product && Object.keys(product).length > 0">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <router-link :to="{name:'productDetails',params:{ slug:product.slug }}">
                            <img :src="product.featured_image" alt=""
                                 class="img-fluid">
                        </router-link>
                    </div>
                    <div class="col-lg-8 ps-xl-0 ps-lg-0 d-flex align-content-between flex-wrap ">
                        <div class="card  horizenter_card_content shadow-none p-0 m-0 p-sm-10 p-md-10">
                            <div class="card-body shadow-nonepb-0 ps-0 pb-0 p-xs-0">
                                <router-link :to="{name:'productDetails',params:{ slug:product.slug }}">
                                    <h5 class="fs-16 mb-0 product-title">
                                        {{ product.name }}
                                    </h5>
                                </router-link>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="fs-12 align-middle text-warning">
                                            <span :class="product.rating >= 1 ? 'ri-star-fill':'ri-star-line'"></span>
                                            <span :class="product.rating >= 2 ? 'ri-star-fill':'ri-star-line'"></span>
                                            <span :class="product.rating >= 3 ? 'ri-star-fill':'ri-star-line'"></span>
                                            <span :class="product.rating >= 4 ? 'ri-star-fill':'ri-star-line'"></span>
                                            <span :class="product.rating >= 5 ? 'ri-star-fill':'ri-star-line'"></span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h6 class="mb-0">
                                            ({{ product.rating }})
                                        </h6>
                                    </div>
                                </div>
                                <p class="pe-2 mt-2 mb-2 text-truncate">
                                    {{ product.short_description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-gl-12">
                        <div class="horizental_product_footer w-100">
                            <div class="row">
                                <div class="col-lg-6 d-flex align-items-center col-sm-12 col-xs-12">
                                            <div class="flex-grow-1">
                                                <h5 class="text-color fs-14 mb-0 main-col d-flex pb-2">
                                                        <span class="pe-1 text-nowrap">
                                                            {{ $root.global.currency_symbol }}{{ product.sale_price | currency }}
                                                        </span>
                                                    <small class="text-decoration-line-through text-muted fs-13">
                                                        {{ $root.global.currency_symbol }}{{ product.dicounted_price }}
                                                    </small>
                                                </h5>
                                            </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <router-link :to="{name:'productDetails',params:{ slug:product.slug }}"
                                                 class="btn bg-color text-white w-100 btn-sm text-nowrap">
                                        <i class="mdi mdi-shopping"></i> Buy Now
                                    </router-link>
                                    <a @click="addToWishlist(product.id)" href="javascript:" title="Wishlist"
                               class="d-block border-color btn btn-sm wishlist ms-1">
                                <i class="text-color bx bx-heart align-bottom me-0 fs-15"></i>
                            </a>
                                </div>
                            </div>
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
            }
        }
    }
</script>

<style scoped lang="scss">
    .placeholder.placeholder-image {
        height: 145px;
        border-radius: 5px 5px 0 0;
    }

    .product-title {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>
