<template>
    <div class="product-details mt-4">
        <div class="container">
            <div class="card" v-if="product && Object.keys(product).length > 0">
                <div class="card-body">
                    <div class="row gx-lg-5">
                        <div class="col-xl-4 col-md-8 mx-auto">
                            <div class="product-img-slider sticky-side-div">
                                <div class="product-thumbnail-slider p-2 rounded bg-light">
                                    <VueSlickCarousel
                                        v-if="product && Object.keys(product.product_gallery).length > 0"
                                        ref="c1"
                                        :asNavFor="$refs.c2"
                                        :focusOnSelect="true" v-show="c1">
                                        <div class="product-thumbnail-slider p-2 rounded bg-light"
                                             v-for="(image ,index ) in product.product_gallery"
                                             :key="index+'A'"
                                             v-if="image">
                                            <img :src="image" class="img-fluid d-block" alt="">
                                        </div>
                                    </VueSlickCarousel>
                                </div>
                                <!-- end swiper thumbnail slide -->
                                <div class="product-nav-slider mt-2">
                                    <VueSlickCarousel
                                        v-if="product && Object.keys(product.product_gallery).length > 0"
                                        ref="c2"
                                        :asNavFor="$refs.c1"
                                        :slidesToShow="4"
                                        :focusOnSelect="true">
                                        <div class="nav-slide-item"
                                             v-for="(image ,i ) in product.product_gallery" :key="i+'A'"
                                             v-if="image">
                                            <img :src="image" class="img-fluid d-block" alt="">
                                        </div>
                                    </VueSlickCarousel>
                                </div>
                                <!-- end swiper nav slide -->
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="mt-xl-0 mt-5">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1 class="fs-24">{{ product.name }}</h1>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                    <div class="text-muted fs-16">
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                        <span class="mdi mdi-star text-warning"></span>
                                    </div>
                                    <div class="text-muted">( {{ totalReview }} Customer Review )</div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-lg-7">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 px-0">
                                                <div class="p-2 d-flex align-items-center">
                                                                <span class="fs-20 text-danger text-muted mx-2">
                                                                    <del>{{ $root.global.currency_symbol }}{{ product.sale_price > 0 ? product.sale_price.toFixed(2) : product.sale_price }}</del>
                                                                </span>
                                                    <span class="fs-24 fw-bold text-color">
                                                                    {{ $root.global.currency_symbol }}{{ product.dicounted_price | currency }}
                                                                </span>
                                                    <span class="ms-3" v-if="product.unit">({{ product.unit }})</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <template v-if="product.variantProduct && Object.keys(product.variantProduct).length > 0">
                                                <div class="col-lg-12"
                                                     v-for="(variant,vkey) in product.variantProduct"
                                                     :key="vkey+'0'">
                                                    <div class="my-2">
                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                            <h5 class="fs-14">{{ vkey }} :</h5>
                                                            <template v-if="vkey === 'Size'">
                                                                <div v-for="(attr,attKey) in variant"
                                                                     :key="attKey+'1'">
                                                                    <input
                                                                        type="radio" class="btn-check"
                                                                        :name="vkey"
                                                                        v-model="cart.variant_product[vkey]"
                                                                        :value="{attribute:vkey,value:attr.value,price:attr.price}"
                                                                        :id="`variant${vkey}${attKey}`"
                                                                    >
                                                                    <label @click="setVariantPrice(vkey,attr)"
                                                                           class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center"
                                                                           :for="`variant${vkey}${attKey}`">
                                                                        {{ attr.value }}
                                                                    </label>
                                                                </div>
                                                            </template>
                                                            <template v-else>
                                                                <div v-for="(attr,attKey) in variant"
                                                                     :key="attKey+'2'">
                                                                    <div
                                                                        class="form-check form-radio-outline form-radio-primary">
                                                                        <input
                                                                            class="form-check-input"
                                                                            type="radio"
                                                                            :name="vkey"
                                                                            v-model="cart.variant_product[vkey]"
                                                                            :value="{attribute:vkey,value:attr.value,price:attr.price}"
                                                                            :id="`variant${vkey}${attKey}`"
                                                                        >
                                                                        <label @click="setVariantPrice(vkey,attr)"
                                                                               class="form-check-label text-capitalize"
                                                                               :for="`variant${vkey}${attKey}`">
                                                                            {{ attr.value }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- end col -->
                                            <div class="col-lg-12">
                                                <div class="mt-4">
                                                    <div class="d-flex flex-wrap gap-4 align-items-center">
                                                        <div
                                                            class="quantity d-flex flex-wrap gap-2 align-items-center">
                                                            <h5 class="fs-14">Quantity :</h5>
                                                            <div class="input-step">
                                                                <button v-if="quantity > 1" @click="decrement"
                                                                        type="button"
                                                                        class="minus">–
                                                                </button>
                                                                <button v-else disabled="disabled" type="button"
                                                                        class="minus">–
                                                                </button>
                                                                <input type="number" disabled class="product-quantity"
                                                                       :value="quantity" min="0" max="100">
                                                                <button @click="increment" type="button" class="plus">
                                                                    +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="price d-flex flex-wrap gap-2 align-items-center">
                                                            <h5 class="fs-14">Total Price :</h5>
                                                            <h5 class="fs-15 fw-bold">
                                                                {{ $root.global.currency_symbol }}{{ productTotalPrice |
                                                                currency }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="row">
                                            <!-- end col -->
                                            <div class="col-lg-12 mb-2">
                                                <div class="p-2 border border-dashed rounded">
                                                    <h6 class="text-color">Category</h6>
                                                    <div
                                                        class="brand_category mt-2 gap-2 d-flex align-items-center"
                                                        v-if="product.category">
                                                        <img :src="product.category.image" alt="">
                                                        <div class="" v-if="product.category">
                                                            {{ product.category.title }} <br>
                                                            <router-link
                                                                :to="{name:'products',query:{category_id:product.category_id}}">
                                                                View other product
                                                            </router-link>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-12">
                                                <div class="p-2 border border-dashed rounded">
                                                    <h6 class="text-color">Brand</h6>
                                                    <div
                                                        class="brand_category mt-2 gap-2 d-flex align-items-center"
                                                        v-if="product.brand">
                                                        <img :src="product.brand.icon" alt="">
                                                        <div class="" v-if="product.brand">
                                                            {{ product.brand.name }} <br>
                                                            <router-link
                                                                :to="{name:'products',query:{brand:product.brand_id}}">
                                                                View other product
                                                            </router-link>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <a href="javascript:" @click="addToCart" :disabled="btnLoader"
                                           class="btn bg-color text-white border-color btn-border d-block w-100">
                                            <i v-if="!btnLoader" class="mdi mdi-shopping-outline"></i>
                                            <i v-else class="mdi mdi-sync mdi-spin"></i>
                                            Add To Cart
                                        </a>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="javascript:" @click="addToWishlist(product.id)"
                                           class="btn btn-danger btn-border d-block w-100">
                                            <i class="mdi mdi-cards-heart-outline"></i> Add To Wishlist
                                        </a>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <!-- Share Options -->


                                    <!-- Share options end -->
                                    <div class="col-lg-2 col-3 mt-2"><span class="opacity-60 fs-30">Share
                                            </span></div>

                                    <div class="col-lg-10 col-9 social-icons">
                                        <div>
                                            <a class=""
                                               :href="`https://www.facebook.com/sharer/sharer.php?u=${$root.baseurl+'/product'+ product.slug }`"><i
                                                class=" ri-facebook-circle-fill"></i></a>


                                            <a class=""
                                               :href="`https://twitter.com/share?url=${$root.baseurl+'/product'+ product.slug }&text=''via='text'`"><i
                                                class="ri-twitter-fill"></i></a>

                                            <a class=""
                                               :href="`https://www.linkedin.com/shareArticle?url=${$root.baseurl+'/product'+ product.slug }&title=<TITLE>&summary=<SUMMARY>&source=${$root.baseurl}`"><i
                                                class=" ri-linkedin-box-fill"></i></a>
                                            <a class=""
                                               :href="`https://www.instagram.com/sharer.php?u=${$root.baseurl+'/product'+ product.slug }`"><i
                                                class="ri-instagram-fill"></i></a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-description">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header ">
                                <h4>Top Selling Products</h4>
                            </div>
                        </div>
                        <div class="col-lg-12" v-for="(product,pkey) in topSelling" :key="pkey">
                            <HorizontalProduct :product="product"></HorizontalProduct>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <!-- end row -->
                                <div class="product-content">
                                    <nav>
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="nav-speci-tab"
                                                   data-bs-toggle="tab" href="#nav-speci" role="tab"
                                                   aria-controls="nav-speci" aria-selected="true">Specification</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                   href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                   aria-selected="false" tabindex="-1">Description</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="nav-ratings-reviews-tab" data-bs-toggle="tab"
                                                   href="#nav-ratings-reviews" role="tab" aria-controls="nav-detail"
                                                   aria-selected="false" tabindex="-1">Ratings & Reviews</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-speci"
                                             role="tabpanel" aria-labelledby="nav-speci-tab">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <tbody>
                                                    <tr v-if="product.category">
                                                        <th scope="row">Category</th>
                                                        <td>{{ product.category.title }}</td>
                                                    </tr>
                                                    <tr v-if="product.brand">
                                                        <th scope="row">Brand</th>
                                                        <td>{{ product.brand.name }}</td>
                                                    </tr>
                                                    <tr v-for="(spec,skey) in product.specifications" :key="skey">
                                                        <th>{{ spec.spec_name }}</th>
                                                        <td>{{spec.spec_values }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-detail" role="tabpanel"
                                             aria-labelledby="nav-detail-tab">
                                            <div>
                                                <h5 class="font-size-16 mb-3">{{ product.name }}
                                                </h5>
                                                <p>{{ product.description }}</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-ratings-reviews" role="tabpanel"
                                             aria-labelledby="nav-ratings-reviews-tab">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">Average Rating {{productReview.avg_rating}} out of
                                                    5</h6>
                                            </div>
                                            <div class="row gy-4 gx-0">
                                                <div class="col-lg-4">
                                                    <div>
                                                        <div class="pb-3 pt-2">
                                                            <div class="bg-light px-3 py-2 rounded-2 mb-2">

                                                                <div class="d-flex align-items-center">

                                                                    <div class="flex-grow-1"
                                                                         v-if="$root.userLoggedIn==false">
                                                                        <h5 class="mb-0">Log In to Submit a
                                                                            Review</h5>
                                                                    </div>


                                                                    <form @submit.prevent="AddRatingReview"
                                                                          v-if="$root.userLoggedIn==true">
                                                                        <input type="hidden"
                                                                               v-model="form.product_id"/>

                                                                        <div class="flex-shrink-0">

                                                                            <div
                                                                                class="fs-16 align-middle text-warning">
                                                                                <star-rating
                                                                                    v-model="form.rating"></star-rating>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-shrink-0">
                                                                            <div class="mb-3 pb-2 pt-2">
                                                                                <label
                                                                                    for="exampleFormControlTextarea"
                                                                                    class="form-label">Write Your
                                                                                    Review</label>
                                                                                <textarea class="form-control"
                                                                                          v-model="form.comment"
                                                                                          id="exampleFormControlTextarea"> </textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="hstack gap-2 justify-content-start">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary">Add
                                                                                Review
                                                                            </button>

                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <div class="text-muted">Total <span
                                                                    class="fw-medium">{{ totalReview }}</span>
                                                                    reviews
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <!-- end col -->

                                                <div class="col-lg-8">
                                                    <div class="ps-lg-4">
                                                        <div class="d-flex flex-wrap align-items-start gap-3">
                                                            <h5 class="fs-14">Reviews: </h5>
                                                        </div>

                                                        <div class="me-lg-n3 pe-lg-4" data-simplebar="init"
                                                             style="max-height: 225px;">
                                                            <div class="simplebar-wrapper"
                                                                 style="margin: 0px -24px 0px 0px;">
                                                                <div class="simplebar-height-auto-observer-wrapper">
                                                                    <div
                                                                        class="simplebar-height-auto-observer"></div>
                                                                </div>
                                                                <div class="simplebar-mask">
                                                                    <div class="simplebar-offset"
                                                                         style="right: 0px; bottom: 0px;">
                                                                        <div class="simplebar-content-wrapper"
                                                                             tabindex="0" role="region"
                                                                             aria-label="scrollable content"
                                                                             style="height: auto; overflow: hidden scroll;">
                                                                            <div class="simplebar-content"
                                                                                 style="padding: 0px 24px 0px 0px;">
                                                                                <ul class="list-unstyled mb-0"
                                                                                    v-for="(review,rkey) in productReview.all_review"
                                                                                    :key="rkey">
                                                                                    <li class="py-2">
                                                                                        <div
                                                                                            class="border border-dashed rounded p-3">
                                                                                            <div
                                                                                                class="d-flex align-items-start mb-3">
                                                                                                <div
                                                                                                    class="hstack gap-3">
                                                                                                    <div
                                                                                                        class="badge rounded-pill bg-color mb-0">
                                                                                                        <i class="mdi mdi-star"></i>
                                                                                                        {{review.rating}}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="vr"></div>
                                                                                                    <div
                                                                                                        class="flex-grow-1">
                                                                                                        <p class="text-muted mb-0">
                                                                                                            {{review.comment}}</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div
                                                                                                class="d-flex align-items-end">
                                                                                                <div
                                                                                                    class="flex-grow-1">
                                                                                                    <h5 class="fs-14 mb-0">
                                                                                                        {{
                                                                                                        review.user.name
                                                                                                        }}</h5>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="flex-shrink-0">
                                                                                                    <p class="text-muted fs-13 mb-0">
                                                                                                        {{
                                                                                                        review.day
                                                                                                        }}</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>


                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="simplebar-placeholder"
                                                                     style="width: auto; height: 484px;"></div>
                                                            </div>
                                                            <div class="simplebar-track simplebar-horizontal"
                                                                 style="visibility: hidden;">
                                                                <div class="simplebar-scrollbar"
                                                                     style="width: 0px; display: none;"></div>
                                                            </div>
                                                            <div class="simplebar-track simplebar-vertical"
                                                                 style="visibility: visible;">
                                                                <div class="simplebar-scrollbar"
                                                                     style="height: 104px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end col -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- product-content -->
                            </div>
                        </div>
                        <section id="hot_product">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Hot Products</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-md-3 col-xxl-2 col-6" v-for="(product,pkey) in hotProducts"
                                     :key="pkey">
                                    <Product :product="product"></Product>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
    import StarRating from 'vue-star-rating'

    export default {
        name: "ProductDetails",
        components: {VueSlickCarousel, StarRating},
        data() {
            return {
                btnLoader: false,
                product: {
                    product_gallery: [],
                },
                selectedVariant: [],
                variantPrice: 0,

                productPrice: 0,
                quantity: 1,
                total_price: 0,

                cart: {
                    variant_product: {},
                    total_price: 0,
                    quantity: 1,
                },
                defualtVariant: null,
                productReview: [],
                totalReview: '',
                topSelling: [],
                hotProducts: [],
                form: {
                    product_id: '',
                    rating: null,
                    comment: '',
                },
                c1: undefined,
                c2: undefined,
            }
        },
        computed: {
            productTotalPrice() {
                let totalVariantPrice = 0;
                if (Object.keys(this.selectedVariant).length > 0){
                    this.selectedVariant.forEach(item => {
                        totalVariantPrice += item.attribute_price
                    });
                }
                let price = parseInt(this.productPrice + totalVariantPrice)
                this.total_price = price;
                return price * this.quantity;
            }
        },
        watch: {
            $route: {
                handler() {
                    this.getProductDetails();
                    this.getProductreviews();
                },
                deep: true,
                immediate: true,
            },
            'cart.variant_product': {
                handler(value) {
                    let attrObj = Object.keys(value)
                    if (attrObj.length > 0) {
                        this.cart.total_price += parseInt(value[attrObj[0]].price);
                    } else if (attrObj.length > 1) {
                        this.cart.total_price += parseInt(value[attrObj[1]].price);
                    } else if (attrObj.length > 2) {
                        this.cart.total_price += parseInt(value[attrObj[2]].price);
                    }
                },
                deep: true,
                immediate: true,
            },
        },
        methods: {
            increment() {
                this.quantity += 1;
            },
            decrement() {
                this.quantity -= 1;
            },
            setVariantPrice(attribute,attribute_value) {
                let setAttribute = {
                    attribute_name: attribute,
                    attribute_price: attribute_value.price ? parseInt(attribute_value.price) : 0,
                    attribute_value: attribute_value.value,
                }
                let found =  this.selectedVariant.find(variant => variant.attribute_name == attribute);
                if (found) {
                    if (found.attribute_price != attribute_value.price){
                        found.attribute_price = attribute_value.price ? parseInt(attribute_value.price) : 0;
                    }
                }else{
                    this.selectedVariant.push(setAttribute);
                }
            },
            addToCart() {
                if (Object.keys(this.cart.variant_product).length != Object.keys(this.product.variantProduct).length) {
                    this.notification('Please Select All Attribute or Options', 'error');
                    return false;
                }
                this.btnLoader = true;
                let product = {
                    discount_amount: this.product.discount_amount,
                    featured_image: this.product.featured_image,
                    id: this.product.id,
                    variant: this.selectedVariant,
                    name: this.product.name,
                    quantity: this.quantity,
                    sale_price: this.total_price,
                    slug: this.product.slug,
                    tax_amount: this.product.tax_amount,
                    vat_amount: this.product.vat_amount,
                }
                this.$store.commit('ADD_TO_CART', product);
                this.$store.commit('SAVE_CART');
                this.notification('Product has been added in your cart!', 'success');
                setTimeout(() => {
                    this.btnLoader = false;
                }, 100)
            },
            async getProductDetails() {
                let slug = this.$route.params.slug;
                await axios.get('product/details/' + slug).then(res => {
                    this.product = res.data;
                    this.form.product_id = this.product.id;
                    this.productPrice = res.data.dicounted_price;
                }).catch(error => {
                    console.log(error)
                })
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
            AddRatingReview() {
                axios.post('user/storereview', this.form).then((response) => {
                    if (response) {
                        if (response.data.exists == true) {
                            this.notification("You have already added a Review for this product !!!", "error");
                            this.getProductreviews();
                        }
                        if (response.data.success == true) {
                            this.notification("Review Added Successfully !!!", "success");
                        }
                    }
                }).catch((error) => {
                    console.log(error)
                })
            },
            getProductreviews() {
                setTimeout(() => {
                    axios.get('user/productreviews/' + this.product.id).then((response) => {
                        this.productReview = response.data
                        this.totalReview = this.productReview.total_reviews;
                    }).catch((error) => {
                        console.log(error)
                    })
                }, 1000)
            }
        },
        mounted() {
            axios.get('topselling-products').then((response) => {
                this.topSelling = response.data;
            }).catch((error) => {
                console.log(error)
            });
            axios.get('hot-products').then((response) => {
                this.hotProducts = response.data;
            }).catch((error) => {
                console.log(error)
            });
            setTimeout(() => {
                this.c1 = this.$refs.c1;
                this.c2 = this.$refs.c2;
            }, 1000);
        },
    }
</script>
<style lang="scss">
    .product-img-slider .product-nav-slider .nav-slide-item {
        width: 84px !important;
    }

    .brand_category {
        img {
            height: 50px;
            width: 50px;
        }
    }

    .slick-prev, .slick-next {
        height: 32px;
        width: 32px;
        background-color: rgba(64, 81, 137, .2);
        -webkit-backdrop-filter: blur(2px);
        backdrop-filter: blur(2px);
        border-radius: 8px;
    }

    .slick-prev::after, .slick-next::after {
        font-family: remixicon;
        font-size: 28px;
        color: #405189;
        -webkit-transition: all .3s ease;
        transition: all .3s ease;
        position: absolute;
        left: 3px;
    }

    .slick-prev:before {
        display: none;
    }

    .slick-prev::after {
        content: "\ea64" !important;
    }

    .slick-next:before {
        display: none;
    }

    .slick-next::after {
        content: "\ea6e" !important;
    }

    .slick-prev {
        left: 0px !important;
        z-index: 12;
    }

    .slick-next {
        right: 0px !important;
    }

    .social-icons i {
        font-size: 35px;
    }

    .fs-30 {
        font-size: 23px !important;
    }

    .ri-twitter-fill {
        color: #1DA1F2;
    }

    .ri-linkedin-box-fill {
        color: #0A66C2;
    }

    .ri-instagram-fill {
        color: #C13584;
    }

</style>
