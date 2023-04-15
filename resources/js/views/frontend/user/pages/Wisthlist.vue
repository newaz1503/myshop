<template>
    <section id="latest_product">
        <div class="">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card card-height-100 mb-0 bg-transparent shadow-none">
                        <div class="card-header border-0">
                            <div class="row g-4">
                                <div class="col-sm-auto d-flex align-items-center">
                                    <div>
                                        <h4>Wishlist Product</h4>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box ms-2">
                                            <input type="text" class="form-control" v-model="searchTerm"
                                                   placeholder="Search Product...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0  ps-0 pe-0">
                            <div class="row">
                                <div class="col-lg-3" v-for="(wishlistitem, index) in filtersearch" :key="index">
                                    <div class="card ribbon-box ribbon-fill shadow-sm card-height-100">
                                        <div class="ribbon-two ribbon-two-primary">
                                            <span class=" bg-color">Latest</span>
                                        </div>
                                        <div class="card-body pb-0">
                                            <img :src="wishlistitem.product.featured_image" alt="" class="img-fluid">
                                            <router-link :to="{name:'productDetails',params:{ slug:wishlistitem.product.slug }}">
                                                 <h5 class="fs-15 mb-0">{{ wishlistitem.product.name }} </h5>
                                             </router-link>

                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="fs-16 align-middle text-warning">
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-half-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h6 class="mb-0">
                                                        4.5<i class="ri-star-fill text-warning"></i>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center gy-3">
                                                <div class="col-sm">
                                                    <div class="d-flex flex-wrap my-n1">
                                                        <div>
                                                            <div class="flex-grow-1">
                                                                <h5 class="text-color fs-14 mb-0 main-col">
                                                                    <span>${{ wishlistitem.product.sale_price }}</span>
                                                                    <small
                                                                        class="text-decoration-line-through text-muted fs-13">$37.45</small>
                                                                </h5>
                                                            </div>

                                                        </div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <a href="javascript:" :id="wishlistitem.id"
                                                           @click="WishlistRemove(wishlistitem.id)"
                                                           title="remove from wishlist" class="d-block text-body">
                                                            <i class="text-color  bx bxs-trash align-bottom me-1 fs-15"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "Wisthlist",
    data() {
        return {
            wishlists: [],
            searchTerm: ''
        }
    },
    computed: {
        filtersearch() {
            return this.wishlists.filter(wishlistitem => {
                return wishlistitem.product.name.toLowerCase().match(this.searchTerm.toLowerCase())
            })
        }
    },

    mounted() {
        this.getWishlist();
    },
    methods: {
        // Get Wishlist Products

        getWishlist(){
            axios.get('user/wishlist-products').then((response) => {
                this.wishlists = response.data;
            }).catch((error) => {
                console.log(error)
            })
        },
        WishlistRemove(id) {
            axios.post('user/removeFromWishlist/' + id).then((response) => {
                if (response.data.success == true) {
                    this.notification("Product Removed from Wishlist Successfully !!!", "success");
                    this.getWishlist();
                }
            }).catch((error) => {
                console.log(error)
            })
        }
    }

}

</script>

<style scoped>

</style>
