<template>
    <div class="a4printer">
        <div class="card" id="printArea">
            <div class="row" >
                <div class="col-lg-12">
                    <div class="card-header border-bottom-dashed p-4">
                        <div class="">
                            <div class="flex-grow-1 align-items-center">
                                <img height="45" v-if="$root.global.logo" :src="$root.global.logo" alt="Logo"
                                     class="text-center">
                                <h2 class="ms-0" v-if="$root.global.app_name">{{$root.global.app_name}}</h2>
                            </div>
                            <div class="flex-shrink-0 mt-2">
                                <div class="">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-0">Address</h6>
                                    <p class="text-muted mb-0" id="address-details" v-if="$root.global.store_address">
                                        {{$root.global.store_address}}</p>
                                    <p class="text-muted mb-0" id="zip-code" v-if="$root.global.store_phone"><span>Phone:</span>
                                        {{$root.global.store_phone}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-header-->

                </div>
                <div class="col-lg-12">
                    <div class="card-body ps-4 py-1">
                        <div class="row g-3">
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Invoice No</p>
                                <h5 class="fs-14 mb-0">#<span id="invoice-no">{{ invoice.invoice_id }}</span></h5>
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Date</p>
                                <h5 class="fs-14 mb-0"><span
                                    id="invoice-date">{{ invoice.created_at | formatDate}}</span> <small
                                    class="text-muted" id="invoice-time">{{ timeFormat(invoice.created_at) }}</small>
                                </h5>
                            </div>
                            <!--end col-->
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">PAYMENT STATUS</p>
                                <span class="badge badge-soft-success fs-11 text-capitalize" id="payment-status">{{ invoice.payment_status}}</span>
                            </div>
                            <!--end col-->
                           <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Payment Method</p>
                                <span class="badge badge-soft-success fs-11 text-capitalize" id="payment-status">{{ invoice.payment_method}}</span>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->

                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            <div class="col-4" v-if="invoice.billingInfo">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>
                                <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                    {{ invoice.billingInfo.address }},
                                    {{ invoice.billingInfo.country? invoice.billingInfo.country.name : '' }},
                                    {{ invoice.billingInfo.state? invoice.billingInfo.state.name: '' }},
                                    {{ invoice.billingInfo.city? invoice.billingInfo.city.name: '' }}
                                </span>
                                <span class="text-muted fw-normal d-block" v-if="invoice.billingInfo.mobile">Phone: {{ invoice.billingInfo.mobile }}</span>
                            </div>
                            <!--end col-->
                            <div class="col-4" v-if="invoice.shippingInfo">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>
                                <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                    {{ invoice.shippingInfo.address }},
                                    {{ invoice.shippingInfo.country? invoice.shippingInfo.country.name : '' }},
                                    {{ invoice.shippingInfo.state? invoice.shippingInfo.state.name: '' }},
                                    {{ invoice.shippingInfo.city? invoice.shippingInfo.city.name: '' }}
                                </span>
                                <span class="text-muted fw-normal d-block">Phone: {{ invoice.shippingInfo.mobile }}</span>
                            </div>
                            <!--end col-->
                            <div class="col-4">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Barcode</h6>
                                <barcode
                                    v-bind:value="invoice.barcode"
                                    :displayValue="false"
                                    :lineColor="'#2a2337'"
                                    height="50px"
                                >
                                </barcode>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                <tr class="table-active">
                                    <th scope="col" style="width: 50px;">#</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col" class="text-end">Total</th>
                                </tr>
                                </thead>
                                <tbody id="products-list"
                                       v-if="invoice.order_details && Object.keys(invoice.order_details).length > 0">
                                <tr v-for="(saleProduct, index) in invoice.order_details" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td class="text-start">
                                        <span class="fw-medium">{{ saleProduct.product ? saleProduct.product.name.substring(0,45) + '...' : 'N/L' }}</span>
                                    </td>
                                    <td>{{ saleProduct.quantity }}</td>
                                    <td>{{ $root.global.currency_symbol }}{{ saleProduct.price | currency }}</td>
                                    <td class="text-end">{{ $root.global.currency_symbol }}{{ saleProduct.total_price | currency }}</td>
                                </tr>
                                </tbody>
                            </table><!--end table-->
                        </div>
                        <div class="border-top border-top-dashed mt-1">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto"
                                   style="width:250px">
                                <tbody>
                                <tr class="" style="">
                                    <td colspan="3" class="Rate text-end">Sub Total</td>
                                    <td class="payment text-end">{{ $root.global.currency_symbol }}{{ invoice.sub_total | currency }}</td>
                                </tr>
                                <tr class="">
                                    <td colspan="3" class="Rate text-end">Total Discount</td>
                                    <td class="payment text-end" v-if="invoice">
                                        {{ $root.global.currency_symbol }}{{ (invoice.product_discount) | currency}}
                                    </td>
                                </tr>
                                <tr class="">
                                    <td colspan="3" class="Rate text-end">Vat & Tax</td>
                                    <td class="payment text-end">{{ $root.global.currency_symbol }}{{ invoice.vat + invoice.tax | currency }}</td>
                                </tr>
                                <tr class="">
                                    <td colspan="3" class="Rate text-end">Shipping Cost</td>
                                    <td class="payment text-end">{{ $root.global.currency_symbol }}{{ invoice.shipping_cost | currency }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="3" class="Rate text-end">Total</td>
                                    <td class="payment text-end">{{ $root.global.currency_symbol }}{{ invoice.grand_total | currency }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <div class="gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:" @click="printHandler('printArea',`Invoice-${invoice.invoice_id}`)"
                               class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print
                            </a>
                        </div>
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>

</template>

<script>
    import VueBarcode from 'vue-barcode';
    import moment from 'moment';

    export default {
        name: "invoice",
        // props:{
        //     invoice:Object,
        // },
        components: {
            'barcode': VueBarcode
        },
        data() {
            return {
                invoice: {}
            }
        },

        mounted() {
            this.getInvoice();
        },

        methods: {
            getInvoice(){
                let invoiceId = this.$route.params.id;
                axios.get('user/invoice/'+invoiceId)
                    .then(res => {
                        this.invoice = res.data
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            timeFormat(date) {
                return moment(date).fromNow();
            },
        },
        computed: {}
    }
</script>

<style scoped>
    .table > :not(caption) > * > * {
        padding: 6px 5px !important;
    }
</style>
