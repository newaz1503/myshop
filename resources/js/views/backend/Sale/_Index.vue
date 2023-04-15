<template>
    <div class="row sale-system">
        <div class="col-lg-7">
            <div class="row px-2 mb-3">
                <div class="col-lg-2 px-1">
                    <select name="brand" v-model="search_data.brand_id" class="form-select">
                        <option value="">Brand</option>
                        <option v-for="(brand,bkey) in options.brands" :key="bkey" :value="brand.id">
                            {{ brand.name }}
                        </option>
                    </select>
                </div>
                <div class="col-lg-6 px-1">
                    <input type="text" v-model="search_data.product_name" class="form-control"
                           placeholder="Search by product name">
                </div>
                <div class="col-lg-4 px-1">
                    <input type="text" v-model="search_data.barcode" class="form-control"
                           placeholder="Barcode or QR-Code Scanner">
                </div>
            </div>
            <template v-if="options.categories && Object.keys(options.categories).length > 0">
                <div class="row categories mb-3">
                    <VueSlickCarousel v-bind="settings" v-if="Object.keys(options.categories).length">
                        <div class="col-lg-2 px-1" v-for="(category,cat) in options.categories" :key="cat">
                            <a href="javascript:" :title="category.title" @click="search_data.category_id = category.id"
                               :class="search_data.category_id == category.id ? 'active':''">
                                <div class="p-1 category-item d-flex justify-content-start align-items-center">
                                    <img class="category-image" :src="category.image" alt="">
                                    <span>{{ category.title }}</span>
                                </div>
                            </a>
                        </div>
                    </VueSlickCarousel>
                </div>
            </template>
            <template v-else>
                <div class="row categories px-2 mb-3 placeholder-glow">
                    <div class="col-lg-2 px-1" v-for="cat in 6" :key="cat">
                        <a href="javascript:" class="placeholder category-placeholder"></a>
                    </div>
                </div>
            </template>
            <div class="row px-2 products">
                <template v-if="table.datas && Object.keys(table.datas).length > 0">
                    <div class="col-lg-3 px-1" v-for="(product,index) in table.datas" :key="index">
                        <div v-if="Object.keys(product).length > 0"
                             class="card product-box mb-2 card-animate rounded overflow-hidden position-relative">
                            <span
                                class="badge badge-label position-absolute top-0 start-0 m-2  bg-danger">
                                <i class="mdi mdi-circle-medium"></i> New
                            </span>
                            <a v-show="product.quantity > 0" href="javascript:" @click="addToCart(product)"
                               class="add-to-cart">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-shopping-cart">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </span>
                            </a>
                            <div class="card-body p-0">
                                <div class="product-image">
                                    <img class="img-fluid"
                                         :src="product.featured_image"
                                         alt="">
                                </div>
                                <div class="card-text p-2">
                                    <h6 class="product_name">{{ product.name }}</h6>
                                    <div v-if="product.quantity > 0"
                                         class="price_quantity d-flex justify-content-between align-items-center">
                                        <h6 class="quantity">Stock: {{ product.quantity }}</h6>
                                        <h6 class="price">Price: ${{ product.sale_price }}</h6>
                                    </div>
                                    <div v-else class="price_quantity text-center border border-danger">
                                        <h6 class="m-0 text-danger">Stock out</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <Pagination
                            :url="model"
                            v-if="!$root.spinner"
                            :search_data="search_data"
                        />
                    </div>
                </template>
                <template v-else>
                    <template v-if="$root.isRequestDone == false">
                        <div class="col-lg-3 px-1" v-for="item in 4" :key="item">
                            <div
                                class="card product-box placeholder-glow mb-2 card-animate rounded overflow-hidden position-relative"
                                aria-hidden="true">
                                <div class="product-image placeholder"></div>
                                <div class="card-body">
                                    <h5 class="card-title placeholder-glow">
                                        <span class="placeholder col-6"></span>
                                    </h5>
                                    <p class="card-text placeholder-glow">
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-4"></span>
                                        <span class="placeholder col-4"></span>
                                        <span class="placeholder col-6"></span>
                                    </p>
                                    <div class="price_quantity d-flex justify-content-between align-items-center">
                                        <button class="btn btn-primary d-block w-100"
                                                disabled="disabled"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-lg-12">
                            <div class="card card-body text-center">
                                <img class="img-fluid" :src="$root.baseurl+'/admin/images/nodata.png'" alt="">
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </div>
        <div class="col-lg-5 position-sticky top-50">
            <form action="">
                <div class="row customer-section mb-3">
                    <div class="col-lg-7">
                        <select class="form-select" required v-model="cart.customer_id" name="customer_id" id="">
                            <option :value="0">Walk in Customer</option>
                            <option v-for="(customer,cindex) in options.customers" :value="customer.id" :key="cindex">
                                {{ customer.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-5 text-end">
                        <button class="btn btn-primary bg-gradient" id="addShippingAddress" type="button"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
                            <i class="fa fa-plus-circle"></i> Shipping Address
                        </button>
                    </div>
                </div>
                <div class="row cart-section mb-3">
                    <div class="col-lg-12 px-0">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed"
                                aria-describedby="fixed-header_info">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th class="text-center">Discount</th>
                                    <th>Total</th>
                                    <th><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody v-if="$store.state.cart && Object.keys($store.state.cart).length > 0">
                                <tr v-for="(cart,key) in $store.state.cart" :key="key">
                                    <td class="product">
                                        <input class="" type="text" :value="cart.name" readonly disabled="disabled">
                                    </td>
                                    <td class="d-flex quantity align-items-center justify-content-center">
                                        <a class="minus" v-if="cart.quantity > 1" @click="decrement(cart)"
                                           href="javascript:"><i class="fa fa-minus"></i></a>
                                        <a class="minus" v-else disabled="disabled" href="javascript:"><i
                                            class="fa fa-minus"></i></a>
                                        <input :value="cart.quantity" type="number">
                                        <a class="plus" @click="increment(cart)" href="javascript:"><i
                                            class="fa fa-plus"></i></a>
                                    </td>
                                    <td class="price">
                                        <span>${{ cart.sale_price.toFixed(2) }}</span>
                                    </td>
                                    <td class="discount">
                                        <span>${{ cart.discount_amount.toFixed(2) }}</span>
                                    </td>
                                    <td class="total">
                                        <span>${{ cart.total_price.toFixed(2) }}</span>
                                    </td>
                                    <td class="action">
                                        <a @click="removeProduct(cart)" class="remove" href="javascript:">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row cost-section justify-content-end mb-3">
                    <div class="col-lg-7">
                        <table class="table table-borderless">
                            <tr>
                                <td>Sub Total:</td>
                                <td>
                                    <input required="required" type="number" disabled="disabled" readonly="readonly"
                                           class="form-control form-control-sm" :value="totalPrice">
                                </td>
                            </tr>
                            <tr>
                                <td>Total Product Discount:</td>
                                <td>
                                    <input required="required" type="number" name="total_product_discount"
                                           disabled="disabled"
                                           readonly="readonly"
                                           class="form-control form-control-sm" :value="totalProductDiscount">
                                </td>
                            </tr>
                            <tr>
                                <td>Invoice Discount:</td>
                                <td>
                                    <input
                                        required="required"
                                        type="number"
                                        name="invoice_discount"
                                        v-model="cart.invoice_discount"
                                        :class="errors.invoice_discount ? 'empty' :'' "
                                        class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <td>Vat:</td>
                                <td><input type="number" name="total_vat" disabled="disabled"
                                           class="form-control form-control-sm"
                                           :value="totalVat"></td>
                            </tr>
                            <tr>
                                <td>Tax:</td>
                                <td><input type="number" name="total_tax" disabled="disabled"
                                           class="form-control form-control-sm"
                                           :value="totalTax"></td>
                            </tr>
                            <tr>
                                <td>Shipping Cost:</td>
                                <td>
                                    <input
                                        required="required"
                                        type="number"
                                        name="shipping_cost"
                                        v-model="cart.shipping_cost"
                                        :class="errors.shipping_cost ? 'empty' :'' "
                                        class="form-control form-control-sm"
                                        value="00">
                                </td>
                            </tr>
                            <tr>
                                <td>Grand Total:</td>
                                <td>
                                    <input
                                        required="required"
                                        type="number"
                                        name="grand_total"
                                        disabled="disabled"
                                        :value="grandTotal"
                                        class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <td>Total Receive:</td>
                                <td><input required="required"
                                           type="number"
                                           name="recieve_amount"
                                           v-model="cart.total_recieve"
                                           class="form-control form-control-sm"
                                           :class="errors.total_recieve ? 'empty' :'' "
                                           value="00">
                                </td>
                            </tr>
                            <tr>
                                <td>Change:</td>
                                <td><input type="number" name="change" v-model="cart.change"
                                           class="form-control form-control-sm"
                                           value="00"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <button @click="cart.total_recieve = cart.grand_total.toFixed(2)" type="button"
                                    class="btn btn-info btn-border w-100 d-block">
                                Full Pay
                            </button>
                        </div>
                        <div class="col-lg-8">
                            <button v-if="!btnLoader" @click="placeOrder" type="button"
                                    class="btn btn-warning btn-border w-100 d-block">
                                <i class="fa fa-shopping-bag"></i> Place Order
                            </button>
                            <button v-else @click="placeOrder" type="button" disabled="disabled"
                                    class="btn btn-warning bg-gradient btn-border w-100 d-flex btn-load justify-content-center">
                                <span class="spinner-border" role="status"></span> Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <audio id="audio" :src="$root.baseurl+'/admin/music/beep.mp3'"></audio>
        <div class="customer-form">
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWithBackdrop"
                 aria-labelledby="offcanvasWithBackdropLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Add New Customer</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form
                        v-on:submit.prevent="addShipping"
                        enctype="multipart/form-data"
                        id="form"
                        class="row"
                    >
                        <template v-if="cart.customer_id == 0">
                            <Input title="Name" field="name" type="text" col="12" :req="true"/>
                            <Input title="Email" field="email" type="text" col="12" :req="true"/>
                        </template>
                        <template v-if="Object.keys(shippingInfos).length < 1 || addMoreAddress == true">
                            <div class="col-lg-12 text-end" v-show="addMoreAddress == true">
                                <button type="button" @click="addMoreAddress = false"
                                        class="btn btn-sm btn-rounded btn-primary"><i
                                    class="fa fa-arrow-circle-left"></i></button>
                            </div>
                            <Textarea title="Address" field="address" :req="true" col="12"/>
                            <div class="col-12 form-group" :class="{
                                'has-error': validation.hasError('data.country_id'),
                                'has-success': data.country_id,
                              }">
                                <label for="">Select Country</label>
                                <v-select
                                    :options="options.countries"
                                    :reduce="country => country.country_id"
                                    label="name"
                                    v-model="data.country_id"
                                />
                                <span class="help-block">
                            {{ validation.firstError("data.country_id") }}
                          </span>
                            </div>
                            <div class="col-12 form-group" :class="{
                            'has-error': validation.hasError('data.state_id'),
                            'has-success': data.state_id,
                          }">
                                <label for="">Select State</label>
                                <v-select
                                    :options="options.states"
                                    :reduce="state => state.state_id"
                                    label="name"
                                    v-model="data.state_id"
                                />
                                <span class="help-block">
                            {{ validation.firstError("data.state_id") }}
                          </span>
                            </div>
                            <div class="col-12 form-group" :class="{
                                'has-error': validation.hasError('data.city_id'),
                                'has-success': data.city_id,
                              }">
                                <label for="">Select City</label>
                                <v-select
                                    :options="options.cities"
                                    :reduce="city => city.id"
                                    label="name"
                                    v-model="data.city_id"
                                />
                                <span class="help-block">
                            {{ validation.firstError("data.city_id") }}
                          </span>
                            </div>
                            <Input title="Postal Code" field="postal_code" type="number" col="12" :req="false"/>
                            <Input title="Mobile" field="mobile" type="number" col="12" :req="true"/>
                            <!-------------- button -------------->
                            <div class="col-12 mb-3 mt-2">
                                <Button title="Submit" process=""/>
                            </div>
                            <!-------------- button -------------->
                        </template>
                        <template v-else>
                            <template v-for="(shiInfo,sf) in shippingInfos">
                                <label class="position-relative"
                                       @click="cart.shipping_id = cart.shipping_id ? null : shiInfo.id">
                                    <div class="card ribbon-box border right shadow-none mb-lg-0 cursor-pointer border"
                                         :key="sf"
                                         :class="cart.shipping_id == shiInfo.id ? 'border-success selected':''"
                                    >
                                        <div class="card-body">
                                            <div class="ribbon ribbon-primary round-shape px-3">{{ sf+1 }}</div>
                                            <div class="remove-icon position-absolute end-0 bottom-0 my-3 mx-2">
                                                <a href="javascript:" @click="revomeShippingInfo(shiInfo.id)"
                                                   type="button"
                                                   class="btn btn-rounded btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                            <div class="selected-icon" v-if="cart.shipping_id == shiInfo.id">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="">
                                                <div>
                                                    <span class="alpha-6"><b>Address:</b></span>
                                                    <span class="">{{ shiInfo.address }}</span>
                                                </div>
                                                <div>
                                                    <span class="alpha-6"><b>Postal Code:</b></span>
                                                    <span class="">{{ shiInfo.postal_code }}</span>
                                                </div>
                                                <div>
                                                    <span class="alpha-6"><b>City:</b></span>
                                                    <span class="" v-if="shiInfo.country">{{ shiInfo.city.name }}</span>
                                                </div>
                                                <div>
                                                    <span class="alpha-6"><b>State:</b></span>
                                                    <span class="" v-if="shiInfo.state">{{ shiInfo.state.name }}</span>
                                                </div>
                                                <div>
                                                    <span class="alpha-6"><b>Country:</b></span>
                                                    <span class=""
                                                          v-if="shiInfo.country">{{ shiInfo.country.name }}</span>
                                                </div>
                                                <div>
                                                    <span class="alpha-6"><b>Phone:</b></span>
                                                    <span class="">{{ shiInfo.mobile }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </template>
                            <div class="col-lg-12" v-if="!cart.shipping_id">
                                <button @click="addMoreAddress = true" type="button"
                                        class="btn btn-light w-100 d-block py-3">Add New Address
                                </button>
                            </div>
                        </template>
                    </form>
                </div>
            </div>
        </div>
        <b-modal id="placeOrderSuccessfully" centered>
            <div class="header-image">
                <img :src="$root.baseurl+'/admin/images/complete.gif'" alt="">
            </div>
            <div class="body text-center">
                <h3>Your order has been placed successfully!</h3>
                <button class="btn btn-success">Continue <i class="fa fa-arrow-right"></i></button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

    // define model name
    const model = "sale";
    const tableColumns = [
        {field: "title", title: "Title"},
        {field: "shipping_cost", title: "Shipping Cost"},
        {field: "status", title: "Status"},
    ];
    //json fields for export excel
    const json_fields = {
        Title: "title",
        "Created at": "created_at"
    };
    export default {
        components: {VueSlickCarousel},
        data() {
            return {
                model: model,
                json_fields: json_fields,
                fields_name: {0: "Select One", title: "Title"},
                btnLoader: false,
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
                    change: null
                },
                search_data: {
                    pagination: 10,
                    field_name: 0,
                    value: "",
                    brand_id: '',
                    category_id: ''
                },
                table: {
                    columns: tableColumns,
                    routes: {},
                    datas: [],
                    meta: [],
                    links: []
                },
                // Shipping info
                addMoreAddress: false,
                shippingInfos: [],
                data: {
                    address: '',
                    country_id: '',
                    state_id: '',
                    city_id: '',
                },
                options: {
                    brands: [],
                    categories: [],
                    customers: [],
                    countries: [],
                    states: [],
                    cities: [],
                },
                settings: {
                    "arrows": true,
                    "autoplay": false,
                    "slidesToShow": 6,
                    "slidesToScroll": 6,
                    "touchMove": false,
                },
                errors: {
                    invoice_discount: false,
                    shipping_cost: false,
                    shipping_id: false,
                    total_recieve: false,
                },
            };
        },
        watch: {
            search_data: {
                handler() {
                    this.search();
                },
                deep: true,
                immediate: true
            },
            'cart.total_recieve'(value) {
                const total_recieve = value ? value : 0;
                this.cart.change = (this.grand_total - parseInt(total_recieve));
            },
            'data.country_id'(countryId) {
                this.getStates(countryId);
                this.getCities(countryId);
            },
            'data.state_id'(stateId) {
                this.getCities(this.data.country_id, stateId);
            },
            'cart.customer_id'(userId) {
                this.getShippingInfo(userId);
            }
        },
        computed: {
            totalPrice() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.total_price;
                }
                this.cart.sub_total = total;
                return total.toFixed(2);
            },
            totalProductDiscount() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.discount_amount;
                }
                this.cart.product_discount = total;
                return total.toFixed(2);
            },
            totalVat() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.vat_amount;
                }
                this.cart.vat = total
                return total.toFixed(2);
            },
            totalTax() {
                let total = 0;
                for (let item of this.$store.state.cart) {
                    total += item.tax_amount;
                }
                this.cart.tax = total
                return total.toFixed(2);
            },
            grandTotal() {
                const shippingCost = this.cart.shipping_cost ? this.cart.shipping_cost : 0;
                const invoiceDiscount = this.cart.invoice_discount ? this.cart.invoice_discount : 0;
                const discount = parseInt(invoiceDiscount) + parseInt(this.totalProductDiscount);
                const totalCost = parseInt(this.totalPrice) + parseInt(this.totalTax) + parseInt(this.totalVat) + parseInt(shippingCost);
                const total = totalCost - discount;
                this.cart.grand_total = total;
                return total.toFixed(2);
            }
        },
        methods: {
            addToCart(product) {
                this.playMusic();
                this.$store.commit('ADD_TO_CART', product)
                this.$store.commit('SAVE_CART')
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
            search() {
                this.table.datas = [];
                this.$route.query.page = "";
                this.get_paginate_data(this.model, this.search_data);
            },
            getProducts() {
                axios.get('sale-products', {params: this.search_data}).then(res => {
                    res.products = res.data;
                })
            },
            playMusic() {
                var audio = document.getElementById("audio");
                audio.play();
            },
            addShipping() {
                this.$validate().then((res) => {
                    const error = this.validation.countErrors();
                    // If there is an error
                    if (error > 0) {
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "warning"
                        );
                        return false;
                    }

                    // If there is no error
                    if (res) {
                        this.data['user_type'] = 'local';
                        this.data['user_id'] = this.cart.customer_id;
                        axios.post('shipping/store', this.data).then(res => {
                            this.cart.shipping_id = res.data.shipping_id
                            this.cart.customer_id = res.data.user_id;

                            this.addMoreAddress = false;
                            this.getShippingInfo(this.cart.customer_id);
                            this.getCustomer();
                            this.data = [];
                            this.notification(res.data.message, "success");
                        }).catch(error => {
                            if (error.response.status === 422) {
                                this.notification(error.response.data.message, "danger");
                            }
                        })
                    }
                });
            },
            getShippingInfo(userId) {
                axios.get('shipping-info/list', {params: {user_id: userId}}).then(res => {
                    this.shippingInfos = res.data;
                })
            },
            revomeShippingInfo(shippingId) {
                axios.post('shipping-info/destroy', {shipping_id: shippingId}).then(res => {
                    this.notification(res.data.message, "success");
                    this.getShippingInfo(this.cart.customer_id);
                }).catch(error => {
                    console.log(error)
                })
            },
            getStates(countryId) {
                axios.get('states', {params: {country_id: countryId}}).then(res => {
                    this.options.states = res.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            getCities(countryId, stateId = null) {
                let params = {
                    country_id: countryId,
                    state_id: stateId
                }
                axios.get('cities', {params: params}).then(res => {
                    this.options.cities = res.data;
                }).catch(error => {
                    console.log(error)
                })
            },


            //*********** Order place Handler  *************************
            placeOrder() {
                this.cart['products'] =
                    this.cart['total_quantity'] = this.$store.state.cartCount
                // Empty validations
                if (Object.keys(this.$store.state.cart).length < 1) {
                    this.notification("You cart is empty", "error", 'right');
                    return false
                }
                if (!this.cart.invoice_discount) {
                    this.errors.invoice_discount = true
                    this.notification("Invoice discount is required!", "error", 'right');
                    return false
                } else {
                    this.errors.invoice_discount = false
                }
                if (!this.cart.shipping_cost) {
                    this.errors.shipping_cost = true
                    this.notification("Shipping cost is required!", "error", 'right');
                    return false
                } else {
                    this.errors.shipping_cost = false
                }
                if (!this.cart.total_recieve) {
                    this.errors.total_recieve = true
                    this.notification("Total Receive is required!", "error", 'right');
                    return false
                } else {
                    this.errors.total_recieve = false
                }

                this.$root.validation_errors = {};
                this.btnLoader = true
                axios.post(this.model, this.cart)
                    .then(res => {
                        if (res.data.message) {
                            this.notification(res.data.message, "success");
                        } else if (res.data.error) {
                            this.notification(res.data.error, "error");
                        } else if (res.data.warning) {
                            this.notification(res.data.warning, "warning");
                        }
                        this.$store.commit("REMOVE_CART")
                        this.$bvModal.show("placeOrderSuccessfully");
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.$bvModal.show("validate-error");
                            if (error.response.data.exception) {
                                this.$root.exception_errors = error.response.data.exception
                            } else {
                                this.$root.validation_errors = error.response.data.errors || {};
                            }

                            this.notification("You need to fill empty mandatory fields", "warning");
                        }
                    })
                    .then(alw => setTimeout(() => (this.btnLoader = false), 400));
            },
            getCustomer() {
                this.get_options('customers', 'customers')
            },
        },

        async created() {
            await this.get_paginate_data(this.model, this.search_data);
            await this.getRouteName(this.model);
            await this.setBreadcrumbs(this.model, "index");
            await this.get_options('categories', 'categories');
            await this.get_options('brands', 'brands');
            await this.get_options('countries', 'countries')
            await this.getCustomer();
        },
        mounted() {
            this.$bvModal.show("placeOrderSuccessfully");
            document.documentElement.setAttribute("data-sidebar-size", "sm");
            sessionStorage.setItem("data-sidebar-size", "sm");
        },
        beforeDestroy() {
            document.documentElement.setAttribute("data-sidebar-size", "lg");
            sessionStorage.setItem("data-sidebar-size", "lg");
        },
        validators: {
            "data.name": function (value = null) {
                if (this.cart.customer_id == 0) {
                    return Validator.value(value).required("Name is required");
                }
            },
            "data.email": function (value = null) {
                if (this.cart.customer_id == 0) {
                    return Validator.value(value).required("Email is required");
                }
            },
            "data.mobile": function (value = null) {
                return Validator.value(value).required("Mobile is required");
            },
            "data.address": function (value = null) {
                return Validator.value(value).required("Address is required");
            },
            "data.country_id": function (value = null) {
                return Validator.value(value).required("Country is required");
            },
            "data.city_id": function (value = null) {
                return Validator.value(value).required("City is required");
            },
        },

    };
</script>
<style lang="scss">
    .sale-system {

        .categories {
            .category-placeholder {
                display: block;
                height: 38px;
                border-radius: 5px;
                background: #949494;
            }

            a.active {
                .category-item {
                    border: 1px solid #4caf50;
                    box-shadow: 0 1px 2px rgb(116 176 63 / 74%);
                }
            }

            .category-item {
                box-shadow: 0 1px 2px rgb(56 65 74 / 15%);
                padding: 0.25rem !important;
                background: #fff;
                border-radius: 4px;

                img.category-image {
                    height: 30px;
                    width: 30px;
                    border-radius: 4px;
                }

                span {
                    font-size: 12px;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                    overflow: hidden;
                    width: 90px;
                    margin-left: 6px;
                }
            }

            .slick-prev:before, .slick-next:before {
                color: #3f51b5;
            }

            .slick-prev {
                left: 8px;
                z-index: 1;
                opacity: 0;
                visibility: hidden;
            }

            .slick-next {
                right: 8px;
                opacity: 0;
                visibility: hidden;
            }

            &:hover {
                .slick-prev {
                    opacity: 1;
                    visibility: visible;
                }

                .slick-next {
                    opacity: 1;
                    visibility: visible;
                }
            }
        }

        .products {
            overflow-y: auto;
            height: 391px;

            &::-webkit-scrollbar {
                width: 10px;
            }

            &::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            &::-webkit-scrollbar-thumb {
                background: #d1d1d1;
                border-radius: 5px;
            }

            &::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            .product-box {
                a.add-to-cart {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    top: 0;
                    left: 0;
                    opacity: 0;
                    visibility: hidden;
                    height: 100%;
                    width: 100%;
                    background: #ffffff73;
                    position: absolute;
                    text-align: center;
                    transition: .3s;
                    transform: rotateZ(90deg);

                    .icon {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        color: #fff;
                        height: 50px;
                        width: 50px;
                        background: #3f51b5;
                        text-align: center;
                        padding: 10px;
                        border-radius: 50px;
                    }
                }

                .product-image {
                    height: 140px;
                    overflow: hidden;
                }

                h6.product_name {
                    height: 47px;
                    overflow: hidden;
                }

                .price_quantity {
                    border-radius: 5px;
                    padding: 3px 5px;

                    h6.quantity {
                        font-size: 12px;
                        margin: 0;
                        color: #4caf50;
                    }

                    h6.price {
                        font-size: 12px;
                        margin: 0;
                        color: #3f51b5;
                    }
                }

                &:hover {
                    a.add-to-cart {
                        opacity: 1;
                        visibility: visible;
                        transform: rotateZ(0deg);
                    }
                }
            }
        }


        .cart-section {
            background: #ffffff;
            padding: 0px;
            box-shadow: 0 1px 2px rgb(56 65 74 / 15%);
            max-height: 400px;
            overflow-y: auto;
            margin: 0;

            &::-webkit-scrollbar {
                width: 0px;
            }

            .table {
                td {
                    padding: 5px 5px;

                    input {
                        border: 1px solid #4444;
                        border-radius: 3px;
                        padding: 2px 0px;
                    }
                }

                td.product input {
                    width: 145px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    padding: 7px 0px;
                    border: 0;
                    background: transparent;
                }

                td.quantity {
                    padding: 15px 7px;

                    a.minus {
                        font-size: 10px;
                        background: #f44336;
                        width: 20px;
                        height: 20px;
                        padding: 2px;
                        color: #fff;
                        border-radius: 3px;
                        text-align: center;
                        margin-right: 4px;
                    }

                    a.plus {
                        font-size: 10px;
                        background: #4CAF50;
                        width: 20px;
                        height: 20px;
                        padding: 2px;
                        color: #fff;
                        border-radius: 3px;
                        text-align: center;
                        margin-left: 4px;
                    }

                    input {
                        width: 30px;
                        height: 20px;
                        text-align: center;
                    }
                }

                td.price input {
                    width: 50px;
                    text-align: center;
                }

                td.discount {
                    text-align: center;

                    input {
                        width: 40px;
                        text-align: center;
                    }
                }

                td.action a.remove {
                    background: red;
                    color: #fff;
                    height: 25px;
                    width: 25px;
                    display: block;
                    text-align: center;
                    padding: 3px;
                    border-radius: 5px;
                    font-size: 12px;
                }
            }
        }

        .cost-section {
            table.table {
                tr {
                    border: 0;

                    td {
                        text-align: right;
                        font-weight: 600;

                        input {
                            background-color: #fff;
                            margin-left: 12px;
                            width: 150px;
                            height: 32px;
                            margin-bottom: 4px;
                            text-align: right;
                            font-size: 14px;
                        }

                        .form-control:disabled {
                            background: #e7e7e7 !important;
                        }
                    }
                }
            }
        }

        .selected-icon {
            font-size: 50px;
            position: absolute;
            right: 0;
            color: #48c15a;
            margin: 24px;
        }

        .border.border-success.selected {
            border: 1px solid #3ec552 !important;
        }

        input.form-control.form-control-sm.empty {
            border: 1px solid red;
        }
    }

    #placeOrderSuccessfully {
        header.modal-header {
            position: absolute;
            right: 0;
            button.close {
                border: 0;
                background: #514f4f;
                color: #fff;
                border-radius: 5px;
                z-index: 99;
            }
        }
        .header-image {
            width: 100%;
            height: 200px;
            text-align: center;

            img {
                max-width: 100%;
                height: 100%;
            }
        }
    }

</style>
