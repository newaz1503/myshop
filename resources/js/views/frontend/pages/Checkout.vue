<template>
    <section id="checkout_page" class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Shipping Information</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <b-button class="btn btn-border btn-primary mb-3"
                                              v-b-modal="'shipping-form-modal'">Add Address
                                    </b-button>
                                </div>
                            </div>
                            <div class="row gy-3">
                                <template
                                    v-if="shippingAddress && Object.keys(shippingAddress).length > 0">
                                    <div class="col-lg-4 col-sm-6"
                                         v-for="(address,key) in  shippingAddress" :key="key">
                                        <div class="form-check card-radio">
                                            <input
                                                :checked="address.default_shipping ? 'checked':''"
                                                :id="`shippingAddress${key+1}`"
                                                v-model="cart.shipping_id"
                                                class="form-check-input"
                                                :value="address.id"
                                                name="shipping_id"
                                                type="radio"
                                            >
                                            <label class="form-check-label border-dashed"
                                                   :for="`shippingAddress${key+1}`">
                                                <div class="d-flex justify-content-between align-content-center">
                                                        <span class="fs-14 mb-2 d-block">
                                                          {{ address.shipping_type}}
                                                        </span>
                                                    <a class="text-info"
                                                       @click="editShippingInfo(address)"
                                                       href="javascript:void(0);">
                                                        <i class="ri-pencil-fill  align-bottom me-1"></i>Edit
                                                    </a>
                                                </div>
                                                <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                                                    {{ address.address }},
                                                                    {{ address.country? address.country.name : '' }},
                                                                    {{ address.state? address.state.name: '' }},
                                                                    {{ address.city? address.city.name: '' }}
                                                                </span>
                                                <span
                                                    class="text-muted fw-normal d-block">Phone. {{ address.mobile }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="text-center">
                                        <h4 class="text-danger my-5">You don't have any shipping
                                            address!</h4>
                                    </div>
                                </template>
                            </div>
                            <div class="d-flex align-items-center my-2">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Billing Information</h5>
                                </div>
                            </div>
                            <div class="row gy-3">
                                <template
                                    v-if="shippingAddress && Object.keys(shippingAddress).length > 0">
                                    <div class="col-lg-4 col-sm-6"
                                         v-for="(address,key) in  shippingAddress" :key="key">
                                        <div class="form-check card-radio">
                                            <input
                                                :checked="address.default_billing"
                                                :id="`billingAddress${key+1}`"
                                                v-model="cart.billing_id"
                                                class="form-check-input"
                                                :value="address.id"
                                                name="billing_id"
                                                type="radio"
                                            >
                                            <label class="form-check-label border-dashed"
                                                   :for="`billingAddress${key+1}`">
                                                <div class="d-flex justify-content-between align-content-center">
                                                        <span class="fs-14 mb-2 d-block">
                                                          {{ address.shipping_type}}
                                                        </span>
                                                    <a class="text-info"
                                                       @click="editShippingInfo(address)"
                                                       href="javascript:void(0);">
                                                        <i class="ri-pencil-fill  align-bottom me-1"></i>Edit
                                                    </a>
                                                </div>
                                                <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                                                    {{ address.address }},
                                                                    {{ address.country? address.country.name : '' }},
                                                                    {{ address.state? address.state.name: '' }},
                                                                    {{ address.city? address.city.name: '' }}
                                                                </span>
                                                <span
                                                    class="text-muted fw-normal d-block">Phone. {{ address.mobile }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="text-center">
                                        <h4 class="text-danger my-5">You don't have any shipping
                                            address!</h4>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4">
                                <h5 class="fs-14 mb-3">Shipping Method</h5>
                                <div class="row g-4"
                                     v-if="shippingMedthods && Object.keys(shippingMedthods).length > 0">
                                    <div class="col-lg-6" v-for="(shipMethod,skey) in shippingMedthods"
                                         :key="skey">
                                        <div class="form-check card-radio">
                                            <input
                                                :id="`shippingMethod0${skey+1}`"
                                                v-model="cart.shipping_method_id"
                                                :value="shipMethod.id"
                                                name="shipping_method_id"
                                                type="radio"
                                                class="form-check-input"
                                            >
                                            <label class="form-check-label"
                                                   :for="`shippingMethod0${skey+1}`">
                                                                <span v-if="shipMethod.shipping_cost > 0"
                                                                      class="fs-20 float-end mt-2 text-wrap d-block fw-semibold">
                                                                    {{ $root.global.currency_symbol }} {{ shipMethod.shipping_cost | currency }}
                                                                </span>
                                                <span v-else
                                                      class="fs-20 float-end mt-2 text-wrap d-block fw-semibold">
                                                                    Free
                                                                </span>
                                                <span
                                                    class="fs-14 mb-1 text-wrap d-block">{{ shipMethod.title }}</span>
                                                <span class="text-muted fw-normal text-wrap d-block">Delivery within {{ shipMethod.delivery_time }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 payment-method">
                                <h5 class="fs-14 mb-3">Payment Method</h5>
                                <div class="row g-4 justify-content-center">
                                    <div class="col-sm-4 col-md-4 col-6" v-if="paymentMedthods.cash_on_delivery">
                                        <div class="form-check card-radio">
                                            <input
                                                id="cash_on_delivery"
                                                v-model="cart.payment_method"
                                                value="cash_on_delivery"
                                                name="payment_method"
                                                type="radio"
                                                class="form-check-input"
                                            >
                                            <label class="form-check-label p-1" for="cash_on_delivery">
                                                <img class="payment-card-image"
                                                     :src="$root.baseurl+'/images/cards/cash-on-delivery.png'"
                                                     alt=""
                                                >
                                                <p class="fw-700 fs-14">Cash On Delivery</p>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-6" v-if="paymentMedthods.paypal_payment">
                                        <div class="form-check card-radio">
                                            <input
                                                id="paypal_payment"
                                                v-model="cart.payment_method"
                                                value="paypal_payment"
                                                name="payment_method"
                                                type="radio"
                                                class="form-check-input"
                                            >
                                            <label class="form-check-label p-1" for="paypal_payment">
                                                <img class="payment-card-image"
                                                     :src="$root.baseurl+'/images/cards/paypal.png'" alt=""
                                                >
                                                <p class="fw-700 fs-14">Paypal</p>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-6" v-if="paymentMedthods.sslcommerz_payment">
                                        <div class="form-check card-radio">
                                            <input
                                                id="sslcommerz_payment"
                                                v-model="cart.payment_method"
                                                value="sslcommerz_payment"
                                                name="payment_method"
                                                type="radio"
                                                class="form-check-input"
                                            >
                                            <label class="form-check-label p-1" for="sslcommerz_payment">
                                                <img class="payment-card-image"
                                                     :src="$root.baseurl+'/images/cards/sslcommerz2.png'" alt="">
                                                <p class="fw-700 fs-14">Sslcommerz</p>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-6" v-if="paymentMedthods.stripe_payment">
                                        <div class="form-check card-radio">
                                            <input
                                                id="stripe_payment"
                                                v-model="cart.payment_method"
                                                value="stripe_payment"
                                                name="payment_method"
                                                type="radio"
                                                class="form-check-input"
                                            >
                                            <label class="form-check-label p-1" for="stripe_payment">
                                                <img class="payment-card-image"
                                                     :src="$root.baseurl+'/images/cards/stripe.png'" alt=""
                                                >
                                                <p class="fw-700 fs-14">Stripe</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-4">
                    <div class="sticky-side-div">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Order Summary</h5>
                            </div>
                            <div class="card-header bg-soft-light border-bottom-dashed">
                                <div>
                                    <h6 class="mb-2">Have a <span class="fw-semibold">Coupon</span> code ?</h6>
                                </div>
                                <div class="">
                                    <form @submit.prevent="couponApply" class="d-flex gap-4">
                                        <input v-model="cart.coupon_code" class="form-control me-auto" type="text"
                                               placeholder="Enter coupon code"
                                               aria-label="Add Coupon Code here...">
                                        <button type="submit" class="btn btn-primary w-xs">
                                           <span v-if="couponBtnLoader" class="spinner-border spinner-border-sm"
                                                 role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </span>
                                            <span>Apply</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        <tr>
                                            <td>Sub Total :</td>
                                            <td class="text-end" id="cart-subtotal">
                                                {{ $root.global.currency_symbol }}{{ totalPrice | currency }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Discount <span class="text-muted"></span> :</td>
                                            <td class="text-end" id="cart-discount">
                                                {{ $root.global.currency_symbol }}{{ totalProductDiscount | currency }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Charge :</td>
                                            <td class="text-end" id="cart-shipping">
                                                {{ $root.global.currency_symbol }}{{ cart.shipping_cost | currency }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Estimated Vat & Tax :</td>
                                            <td class="text-end" id="cart-tax">{{ $root.global.currency_symbol }} {{
                                                totalTax + totalVat | currency }}
                                            </td>
                                        </tr>
                                        <tr v-if="cart.coupon_discount">
                                            <td>Coupon Discount :</td>
                                            <td class="text-end">{{ $root.global.currency_symbol }}{{
                                                cart.coupon_discount | currency }}
                                            </td>
                                        </tr>
                                        <tr class="table-active">
                                            <th>Total :</th>
                                            <td class="text-end">
                                                <span class="fw-semibold" id="cart-total">
                                                 {{ $root.global.currency_symbol }}{{ grandTotal | currency }}
                                                </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 py-3">
                                    By clicking proceed, I agree to {{ $root.global.app_name }} <br>
                                    <router-link :to="{name:'content.page',params:{slug:'terms-conditions'}}"
                                                 class="text-warning fw-500">
                                        terms and conditions
                                    </router-link>
                                </div>
                                <div class="col-lg-12">
                                    <button @click="placeOrder" class="btn btn-primary btn-border d-block w-100">
                                        <i v-if="$root.spinner" class="mdi mdi-spin mdi-sync"></i> Confirm Now
                                    </button>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
        <b-modal id="shipping-form-modal" hide-footer title="Add Shipping Info">
            <form @submit.prevent="addShipping">
                <div class="form-group col-12" :class="{
                                'has-error': validation.hasError('data.address'),
                                'has-success': data.address,
                              }">
                    <label class="control-label">Address</label>
                    <textarea
                        name="address"
                        placeholder="Address"
                        v-model="data.address"
                        class="form-control form-control-sm">
                    </textarea>
                    <span class="help-block">
                        {{ validation.firstError("data.address") }}
                    </span>
                </div>
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
                <div class="form-group col-12 " :class="{
                                'has-error': validation.hasError('data.postal_code'),
                                'has-success': data.postal_code,
                              }">
                    <label class="">Postal Code</label>
                    <input
                        name="postal_code"
                        placeholder="Postal Code"
                        type="number"
                        class="form-control"
                        v-model="data.postal_code"
                    >
                    <span class="help-block">
                        {{ validation.firstError("data.postal_code") }}
                    </span>
                </div>
                <div class="form-group col-12 " :class="{
                                'has-error': validation.hasError('data.mobile'),
                                'has-success': data.mobile,
                              }">
                    <label class="control-label">Mobile</label>
                    <input
                        name="mobile"
                        placeholder="Mobile"
                        type="number"
                        class="form-control"
                        v-model="data.mobile"
                    >
                    <span class="help-block">
                        {{ validation.firstError("data.mobile") }}
                    </span>
                </div>
                <div class="form-group col-12 mt-4">
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-radio-primary mb-3">
                                <input
                                    v-model="data.shipping_type"
                                    class="form-check-input"
                                    type="radio"
                                    name="shipping_type"
                                    id="homeAddress"
                                    value="Home Address"
                                >
                                <label class="form-check-label" for="homeAddress">
                                    Home Address
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-radio-primary mb-3">
                                <input
                                    v-model="data.shipping_type"
                                    class="form-check-input"
                                    type="radio"
                                    name="shipping_type"
                                    id="officeAddress"
                                    value="Office Address"
                                >
                                <label class="form-check-label" for="officeAddress">
                                    Office Address
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------- button -------------->
                <div class="col-12 mb-3 mt-4 text-end">
                    <button @click="$bvModal.hide('shipping-form-modal')" type="button"
                            class="btn btn-danger btn-border px-4">
                        <span> Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-border btn-primary px-4">
                        <span> Submit</span>
                    </button>
                </div>
            </form>
        </b-modal>
    </section>
</template>

<script>
    export default {
        name: "Checkout",
        data() {
            return {
                couponBtnLoader: false,
                data: {
                    address: '',
                    shipping_type: 'Home Address',
                    country_id: '',
                    state_id: '',
                    city_id: '',
                },
                cart: {
                    coupon_code: null,
                    coupon_discount: 0,
                    coupon_discount_type: null,
                    payment_method: null,
                    sub_total: 0,
                    product_discount: 0,
                    vat: 0,
                    tax: 0,
                    shipping_cost: 0,
                    grand_total: 0,
                },
                shippingAddress: [],
                options: {
                    countries: [],
                    states: [],
                    cities: [],
                },
                shippingMedthods: [],
                paymentMedthods: [],
                stripePayment: {
                    publishableKey: null,
                    sessionId: null
                }
            }
        },
        watch: {
            'data.country_id'(countryId) {
                this.getStates(countryId);
                this.getCities(countryId);
            },
            'data.state_id'(stateId) {
                this.getCities(this.data.country_id, stateId);
            },
            'cart.shipping_method_id'(newVal, oldVal) {
                this.setShippingCost(newVal);
            },
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
                this.cart.product_discount = parseInt(total);
                return parseInt(total);
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
                let total = parseInt(this.totalPrice) - parseInt(this.totalProductDiscount);
                const shippingCost = this.cart.shipping_cost ? this.cart.shipping_cost : 0;
                const totalCost = parseInt(total) + parseInt(this.totalTax) + parseInt(this.totalVat) + parseInt(shippingCost);
                this.cart.grand_total = totalCost;
                return totalCost > 0 ? totalCost : 0;
            }
        },
        methods: {
            setShippingCost(id) {
                axios.get('get-shipping-cost/' + id).then(res => {
                    this.cart.shipping_cost = res.data.shipping_cost
                });
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
                        this.data['user_type'] = 'online';
                        let url = 'shipping/store';
                        if (this.data.id) {
                            url = 'shipping/update/' + this.data.id;
                        }
                        axios.post(url, this.data).then(res => {
                            this.$bvModal.hide('shipping-form-modal');
                            this.data = [];
                            this.getShippingAddress();
                            this.notification(res.data.message, "success");
                        }).catch(error => {
                            if (error.response.status === 422) {
                                this.notification(error.response.data.message, "danger");
                            }
                        })
                    }
                });
            },
            getShippingAddress() {
                axios.get('get-shipping-address').then(res => {
                    this.shippingAddress = res.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            editShippingInfo(address) {
                this.data = address;
                this.$bvModal.show('shipping-form-modal');
            },
            revomeShippingInfo(shippingId) {
                this.$swal.fire({
                    title: 'Are you sure to remove this item?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('shipping-info/destroy', {shipping_id: shippingId}).then(res => {
                            this.notification(res.data.message, "success");
                            this.getShippingAddress();
                        }).catch(error => {
                            console.log(error)
                        })
                        this.$swal.fire('Successfuly Removed!', '', 'success')
                    }
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
            couponApply() {
                let products = [];
                let totalAmount = 0;
                for (let item of this.$store.state.cart) {
                    products.push(item.id);
                    totalAmount += parseInt(item.total_price);
                }
                if (!this.cart.coupon_code) {
                    this.notification('Coupon code is required', 'error');
                    return false;
                }
                this.couponBtnLoader = true;
                axios.post('coupon/apply', {
                    coupon_code: this.cart.coupon_code,
                    verifyFields: {products, totalAmount}
                }).then(res => {
                    if (res.status == 200) {
                        if (res.data.coupon.coupon_type == 'for_products' && res.data.response.find_product == true) {
                            this.cart.coupon_discount = res.data.coupon.discount_amount;
                            this.cart.coupon_discount_type = res.data.coupon.discount_type;
                            this.notification('Congratulations Coupon applyed successfully', 'success');
                        } else {
                            this.notification(res.data.response.error, 'error');
                        }
                        if (res.data.coupon.coupon_type == 'for_total_orders' && res.data.response.order_amount_match == true) {
                            this.cart.coupon_discount = res.data.coupon.discount_amount;
                            this.cart.coupon_discount_type = res.data.coupon.discount_type;
                            this.notification('Congratulations Coupon applyed successfully', 'success');
                        } else {
                            this.notification(res.data.response.error, 'error');
                        }
                    }
                }).catch(error => {
                    this.notification(error.response.data.error, 'error');
                }).finally(() => {
                    this.couponBtnLoader = false;
                })
            },
            //*********** Order place Handler  *************************
            placeOrder() {
                if (Object.keys(this.$store.state.cart).length < 1) {
                    this.notification("You cart is empty", "error", 'right');
                    return false;
                }
                if (!this.cart.shipping_id) {
                    this.notification("Please Select Shipping Address", "error");
                    return false;
                }
                if (!this.cart.billing_id) {
                    this.notification("Please Select Billing Address", "error");
                    return false;
                }
                if (!this.cart.shipping_method_id) {
                    this.notification("Please Select Shipping Method", "error");
                    return false;
                }

                if (!this.cart.payment_method) {
                    this.notification("Please Payment Method", "error");
                    return false
                }
                this.cart['products'] = this.$store.state.cart;
                this.cart['total_quantity'] = this.$store.state.cartCount;
                this.$root.validation_errors = {};
                this.$root.spinner = true;
                axios.post('placeorder', this.cart)
                    .then(res => {
                        if (res.data.payment_method == 'cash_on_delivery') {
                            if (res.data.status == 'success') {
                                this.$store.commit("REMOVE_CART");
                                window.location = res.data.go_to_payment
                            }
                        } else if (res.data.payment_method == 'sslcommerz_payment') {
                            if (res.data.status == 'success') {
                                this.$store.commit("REMOVE_CART");
                                window.location = res.data.go_to_payment
                            }
                        } else if (res.data.payment_method == 'stripe_payment') {
                            if (res.data.status == 'success') {
                                this.$store.commit("REMOVE_CART");
                                window.location = res.data.go_to_payment
                            }
                        } else if (res.data.payment_method == 'paypal_payment') {
                            if (res.data.status == 'success') {
                                this.$store.commit("REMOVE_CART");
                                window.location = res.data.go_to_payment
                            }
                        }
                        if (res.data.message) {
                            this.notification(res.data.message, "success");
                        } else if (res.data.error) {
                            this.notification(res.data.error, "error");
                        } else if (res.data.warning) {
                            this.notification(res.data.warning, "warning");
                        }
                        // this.$store.commit("REMOVE_CART");
                        // this.$bvModal.show("placeOrderSuccessfully");
                        // window.location = this.$root.baseurl + `/admin/sale/create?invoice_id=${res.data.invoice_id}`
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
                    .then(alw => setTimeout(() => (this.$root.spinner = false), 400));
            },
        },
        created() {
            this.getShippingAddress();
            this.get_options('countries', 'countries');
            axios.get('get-shipping-method').then(res => {
                this.shippingMedthods = res.data;
            }),
                axios.get('get-payment-method').then(res => {
                    this.paymentMedthods = res.data;
                })
        },
        validators: {
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
    }
</script>

<style scoped lang="scss">
    .payment-method {
        .form-check.card-radio {
            label {
                text-align: center;

                img.payment-card-image {
                    height: 90px;
                    object-fit: contain;
                    width: 100%;
                }
            }
        }
    }
</style>
