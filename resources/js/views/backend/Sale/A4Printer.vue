<template>
    <div class="a4printer">
        <div class="card" id="printArea">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-header border-bottom-dashed p-4">
                        <div class="">
                            <div class="flex-grow-1 align-items-center">
                                <img height="45" v-if="$root.settings.logo" :src="$root.settings.logo" alt="Logo" class="text-center">
                                <h2 class="ms-0" v-if="$root.settings.app_name">{{$root.settings.app_name}}</h2>
                            </div>
                            <div class="flex-shrink-0 mt-2">
                                <div class="">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-0">Address</h6>
                                    <p class="text-muted mb-0" id="address-details" v-if="$root.settings.store_address">{{$root.settings.store_address}}</p>
                                    <p class="text-muted mb-0" id="zip-code" v-if="$root.settings.store_phone"><span>Phone:</span> {{$root.settings.store_phone}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-header-->
                </div><!--end col-->
                <div class="col-lg-12">
                    <div class="card-body ps-4 py-1">
                        <div class="row g-3">
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Invoice No</p>
                                <h5 class="fs-14 mb-0">#VL<span id="invoice-no">{{ invoice.invoice_id }}</span></h5>
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Date</p>
                                <!-- <h5 class="fs-14 mb-0"><span id="invoice-date">{{ invoice.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</span> <small class="text-muted" id="invoice-time">02:36PM</small></h5> -->
                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{ invoice.created_at | formatDate}}</span> <small class="text-muted" id="invoice-time">{{  timeFormat(invoice.created_at) }}</small></h5>
                                <!-- <p>{{ moment(invoice.created_at, "HH:mm:ss").format("h:mm a") }}</p> -->
                            </div>
                            <!--end col-->
                            <!-- <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Payment Method</p>
                                <span class="badge badge-soft-success fs-11" id="payment-status">COD</span>
                            </div> -->
                            <!--end col-->
                            <!-- <div class="col-lg-3 col-6">
                                <p class="text-muted mb-1 text-uppercase fw-semibold">Total Amount</p>
                                <h5 class="fs-14 mb-0">$<span id="total-amount">{{ invoice.grand_total }}</span></h5>
                            </div> -->
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
                <div class="col-lg-12">
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <td>Invocie #</td>
                                        <td>:</td>
                                        <td>{{ invoice.invoice_id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sold To</td>
                                        <td>:</td>
                                        <td>{{ invoice.customer ? invoice.customer.name : 'N/L' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>:</td>
                                        <td>
                                            <address class="mb-0">
                                                {{ invoice.customer ? invoice.customer.address : 'N/L'}}
                                            </address>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sales Per.</td>
                                        <td>:</td>
                                        <td>Admin</td>
                                    </tr>
                                </table>
                            </div>
                            <!--end col-->
                            <div class="col-6">
                                <barcode
                                    v-bind:value="invoice.barcode"
                                    :displayValue="false"
                                    :lineColor="'#2a2337'"
                                    height="50px"
                                >
                                </barcode>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
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
                                <tbody id="products-list" v-if="invoice.sale_details && Object.keys(invoice.sale_details).length > 0">
                                <tr v-for="(saleProduct, index) in invoice.sale_details" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td class="text-start">
                                        <span class="fw-medium">{{ saleProduct.product ? saleProduct.product.name.substring(0,45) + '...' : 'N/L' }}</span>
                                    </td>
                                    <td>{{ saleProduct.quantity }}</td>
                                    <td>${{ saleProduct.price  }}</td>
                                    <td class="text-end">${{ saleProduct.total_price }}</td>
                                </tr>
                                </tbody>
                            </table><!--end table-->
                        </div>
                        <div class="border-top border-top-dashed mt-1">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                <tbody>
                            <tr class="" style="">
                                <td colspan="3" class="Rate text-end">Sub Total</td>
                                <td class="payment text-end">${{ invoice.sub_total }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Total Discount</td>
                                <td class="payment text-end">${{ invoice.product_discount + invoice.invoice_discount }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Vat & Tax</td>
                                <td class="payment text-end">${{ invoice.vat + invoice.tax }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Shipping Cost</td>
                                <td class="payment text-end">${{ invoice.shipping_cost }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Total Recieve</td>
                                <td class="payment text-end">${{ invoice.total_recieve }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Change</td>
                                <td class="payment text-end">{{ invoice.change }}</td>
                            </tr>
                            <tr class="tabletitle">
                                <td colspan="3" class="Rate text-end">Total (USD)</td>
                                <td class="payment text-end">${{ invoice.grand_total }}</td>
                            </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <div class="mt-4">
                            <div class="alert alert-info">
                                <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                    <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or
                                        credit card or direct payment online. If account is not paid within 7
                                        days the credits details supplied as confirmation of work undertaken
                                        will be charged the agreed quoted fee noted above.
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:" @click="printHandler('printArea','Sale Invoice')" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
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
        props:{
            invoice:Object,
        },
        components: {
            'barcode': VueBarcode
        },
        name: "A4Printer",

        methods:{
            timeFormat(date){
            //  return moment(date).format('h:mm:ss a');
             return moment(date).fromNow();
            }
        },
        computed: {

   }
    }
</script>

<style scoped>
    .table>:not(caption)>*>*{
        padding: 6px 5px !important;
    }
</style>
