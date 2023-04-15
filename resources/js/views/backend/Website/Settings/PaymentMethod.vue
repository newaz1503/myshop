<template>
    <div class="">
        <div class="row">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-6">
                    <!-- Cash On Delivery -->
                    <form @submit.prevent="cashOnDeliveryForm" id="cashOnDeliveryForm">
                        <div class="card ribbon-box right overflow-hidden">
                            <div class="card-body text-center p-4">
                                <img class="avatar-lg" :src="$root.baseurl+'/images/cards/cash-on-delivery.png'" alt=""
                                     height="45">
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Cash on delivery</span>
                                </h5>
                                <div class="row mt-4 justify-content-center">
                                    <div class="col-lg-12 text-center">
                                        <div class="form-check form-switch form-switch-lg ms-4" dir="ltr">
                                            <input type="checkbox" v-model="data.cash_on_delivery" name="cash_on_delivery" class="form-check-input" id="cashOnDeliveryActivation">
                                            <label class="form-check-label"
                                                   for="cashOnDeliveryActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <form @submit.prevent="paypalForm" id="paypalForm">
                    <div class="card ribbon-box right overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <img class="avatar-lg" :src="$root.baseurl+'/images/cards/paypal.png'" alt=""
                                     height="45">
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="w-50 m-auto form-check form-switch form-switch-lg" dir="ltr">
                                            <input type="checkbox" name="paypal_payment" v-model="data.paypal_payment" class="form-check-input"
                                                   id="paypalActivation">
                                            <label class="form-check-label" for="paypalActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Paypal Credential</span>
                                </h5>
                            </div>

                            <div class="row mt-4">
                                <div class="mb-2">
                                    <label class="col-from-label">Paypal Client Id</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="PAYPAL_CLIENT_ID"
                                        placeholder="Paypal Client Id"
                                        v-model="data.PAYPAL_CLIENT_ID"
                                    >
                                </div>
                                <div class="mb-2">
                                    <label class="col-from-label">Paypal Client Secret</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="PAYPAL_CLIENT_SECRET"
                                        placeholder="Paypal Client Secret"
                                        v-model="data.PAYPAL_CLIENT_SECRET"
                                    >
                                </div>
                                <div class="mb-2">
                                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                                        <input type="checkbox" name="paypal_sandbox" v-model="data.paypal_sandbox" class="form-check-input"
                                               id="paypalSandboxActivation">
                                        <label class="form-check-label" for="paypalSandboxActivation">Paypal Sandbox
                                            Mode</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-4 col-lg-6">
                <form @submit.prevent="sslcommerzForm" id="sslcommerzForm">
                    <div class="card ribbon-box right overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <img class="avatar-lg" :src="$root.baseurl+'/images/cards/sslcommerz.png'" alt=""
                                     height="45">
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="w-50 m-auto form-check form-switch form-switch-lg" dir="ltr">
                                            <input type="checkbox" v-model="data.sslcommerz_payment" name="sslcommerz_payment" class="form-check-input"
                                                   id="sslcommerzActivation">
                                            <label class="form-check-label" for="sslcommerzActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Sslcommerz Credential</span>
                                </h5>
                            </div>

                            <div class="row mt-4">
                                <div class="mb-2">
                                    <label class="col-from-label">Sslcz Store Id</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="SSLCZ_STORE_ID"
                                        placeholder="Sslcz Store Id"
                                        v-model="data.SSLCZ_STORE_ID"
                                    >
                                </div>
                                <div class="mb-2">
                                    <label class="col-from-label">Sslcz store password</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="SSLCZ_STORE_PASSWD"
                                        placeholder="Sslcz store password"
                                        v-model="data.SSLCZ_STORE_PASSWD"
                                    >
                                </div>
                                <div class="mb-2">
                                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                                        <label class="form-check-label" for="sslcommerzSandboxMode">Sslcommerz Sandbox
                                            Mode</label>
                                        <input type="checkbox" v-model="data.sslcommerz_sandbox"  name="sslcommerz_sandbox" class="form-check-input"
                                               id="sslcommerzSandboxMode">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-4 col-lg-6">
                <form @submit.prevent="stripeForm" id="stripeForm">
                    <div class="card ribbon-box right overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <img class="avatar-lg" :src="$root.baseurl+'/images/cards/stripe.png'" alt=""
                                     height="45">
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="w-50 m-auto form-check form-switch form-switch-lg" dir="ltr">
                                            <input type="checkbox" v-model="data.stripe_payment" name="stripe_payment" class="form-check-input"
                                                   id="stripeActivation">
                                            <label class="form-check-label" for="stripeActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Stripe Credential</span>
                                </h5>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group">
                                    <label class="col-from-label">Stripe Key</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="STRIPE_KEY"
                                        placeholder="Stripe Key"
                                        v-model="data.STRIPE_KEY"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="col-from-label">Stripe Secret</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="STRIPE_SECRET"
                                        placeholder="Stripe Secret"
                                        v-model="data.STRIPE_SECRET"
                                    >
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PaymentMethod",
        data() {
            return {
                data: {
                    cash_on_delivery: 0,

                    paypal_payment:0,
                    paypal_sandbox:0,
                    PAYPAL_CLIENT_ID:'',
                    PAYPAL_CLIENT_SECRET:'',

                    sslcommerz_payment:0,
                    sslcommerz_sandbox:0,
                    SSLCZ_STORE_ID:'',
                    SSLCZ_STORE_PASSWD:'',

                    stripe_payment:0,
                    STRIPE_KEY:'',
                    STRIPE_SECRET:'',
                }
            }
        },

        methods:{
            submitHandler(url,data){
                this.$root.validation_errors = {};
                this.$root.submit = true;
                this.$root.spinner = true;
                axios.post(url, data).then(res => {
                    if (res.data.message) {
                        this.notification(res.data.message, "success");
                    } else if (res.data.error) {
                        this.notification(res.data.error, "error");
                    } else if (res.data.warning) {
                        this.notification(res.data.warning, "warning");
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.$bvModal.show("validate-error");
                        if (error.response.data.exception) {
                            this.$root.exception_errors = error.response.data.exception
                        } else {
                            this.$root.validation_errors = error.response.data.errors || {};
                        }

                        this.notification("You need to fill empty mandatory fields", "warning");
                    }
                }).finally(() => this.$root.spinner = false);
            },
            cashOnDeliveryForm(){
                let form  = document.getElementById('cashOnDeliveryForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/payment/cash-on-delivery',formData);
            },
            paypalForm(){
                let form  = document.getElementById('paypalForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/payment/paypal',formData);
            },
            sslcommerzForm(){
                let form  = document.getElementById('sslcommerzForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/payment/sslcommerz',formData);
            },
            stripeForm(){
                let form  = document.getElementById('stripeForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/payment/stripe',formData);
            },
            RazorPayForm(){
                let form  = document.getElementById('RazorPayForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/payment/razorpay',formData);
            },
        },
        created() {
            axios.get('setting/payment-methods').then(res => {
                this.data =  res.data;
            }).catch(error => {
                console.log(error)
            })
        }
    }
</script>

<style scoped>

</style>
