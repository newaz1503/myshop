<template>
    <div class="thermal-printer">
        <div id="thermalprinter" style="padding: 2mm;margin: 0 auto;width: 80mm;">
            <center id="top">
                <div class="logo" style="padding: 10px 15px">
                    <img v-if="$root.settings.logo" :src="$root.settings.logo" alt="">
                    <h2 style="font-size: 25px margin-top: 10px" v-if="$root.settings.app_name">{{$root.settings.app_name}}</h2>
                </div>
                <div class="info">
                    <address class="mb-1">
                        {{$root.settings.store_address}}
                        <br>
                        Phone:  {{$root.settings.store_phone}}
                    </address>
                </div>
                <div class="barcode">
                    <barcode
                        v-bind:value="invoice.barcode"
                        :displayValue="false"
                        :lineColor="'#2a2337'"
                        height="25px"
                    >
                    </barcode>
                </div>
            </center>

            <center>
                <div id="mid">
                    <div class="info">
                        <table>
                            <tr>
                                <td>Invocie #</td>
                                <td>:</td>
                                <td>{{ invoice.invoice_id }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>:</td>
                                <td><span id="invoice-date">{{ invoice.created_at | formatDate}}</span> <small class="text-muted" id="invoice-time">{{  timeFormat(invoice.created_at) }}</small></td>
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
                </div><!--End Invoice Mid-->
            </center>

            <center>
                <div id="bot" style="padding-top: 15px">
                    <div id="table">
                        <table class="">
                            <tr class="tabletitle" style="font-size: 14px; border: 1px solid #ebebeb">
                                <td class="item" style="font-size: 14px; padding-left:15px;">Item</td>
                                <td class="Hours text-center" style="font-size: 14px;">Qty</td>
                                <td class="Hours text-center" style="font-size: 14px;">Price</td>
                                <td class="Rate text-end" style="font-size: 14px; padding-right: 15px;">Total</td>
                            </tr>
                            <template v-if="invoice.sale_details && Object.keys(invoice.sale_details).length > 0">
                            <tr class="service" v-for="(saleProduct, index) in invoice.sale_details" :key="index" style="border-bottom: 1px solid #ebebeb;">
                                <td class="tableitem" style="font-size: 14px; padding: 0 15px"><p class="itemtext">{{ saleProduct.product ? saleProduct.product.name.substring(0,15) + '..' : 'N/L' }}</p></td>
                                <td class="tableitem text-center" style="font-size: 14px; padding: 0 15px"><p class="itemtext">{{ saleProduct.quantity }}</p></td>
                                <td class="tableitem text-center" style="font-size: 14px; padding: 0 15px"><p class="itemtext">${{ saleProduct.price  }}</p></td>
                                <td class="tableitem text-end" style="font-size: 14px; padding: 0 15px"><p class="itemtext">${{ saleProduct.total_price }}</p></td>
                            </tr>
                            </template>
                            <tr class="" style="margin-bottom: 5px">
                                <td colspan="3" class="Rate text-end" >Sub Total</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">${{ invoice.sub_total }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Total Discount</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">${{ invoice.product_discount + invoice.invoice_discount }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Vat & Tax</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">${{ invoice.vat + invoice.tax }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Shipping Cost</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">${{ invoice.shipping_cost }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Total Recieve</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">${{ invoice.total_recieve }}</td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="Rate text-end">Change</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">{{ invoice.change }}</td>
                            </tr>
                            <tr class="tabletitle">
                                <td colspan="3" class="Rate text-end">Total (USD)</td>
                                <td class="payment text-end" style="font-size: 14px; padding-right: 15px;">${{ invoice.grand_total }}</td>
                            </tr>

                        </table>
                    </div><!--End Table-->

                    <div id="legalcopy text-center" style="padding-top: 20px; font-weight: 500">
                        <p class="legal" style="padding:0 10px">30% off your next order - <br> if you order throughus with code Local!
                        </p>
                    </div>
                    <a href="https://www.myshop.com">www.myshop.com</a>
                </div><!--End InvoiceBot-->
            </center>
        </div>
        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
            <a href="javascript:" @click="printHandler('thermalprinter','Sale Invoice')" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
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
        name: "ThermalPrinter",
        components: {
            'barcode': VueBarcode
        },
        data(){
            return{
                barcodeValue: '1111111',
            }
        },
        methods:{
            timeFormat(date){
            //  return moment(date).format('h:mm:ss a');
             return moment(date).fromNow();
            }
        }
    }
</script>

<style scoped lang="scss">
    #thermalprinter {
        padding: 2mm;
        margin: 0 auto;
        width: 80mm;
        background: #FFF;
        border: 1px dashed #4444;
        ::selection {
            background: #f31544;
            color: #FFF;
        }
        ::moz-selection {
            background: #f31544;
            color: #FFF;
        }
        h1 {
            font-size: 1.5em;
            color: #222;
        }

        h2 {
            font-size: 12px;
            margin: 0;
            padding: 5px 5px;
        }

        h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p {
            color: #666;
            line-height: 25px;
            margin: 0;
        }

        #top, #mid, #bot { /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #top {
            min-height: 100px;
        }

        #mid {
            min-height: 80px;
        }

        #bot {
            min-height: 50px;
        }

        #top .logo {
            height: 60px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            img{
                width: 45px;
                height: 45px;
                margin: 0 10px 0 0;
            }
            h2{
                font-size: 20px;
                font-weight: 900;
            }
        }

        .info {
            display: block;
            margin-left: 0;
        }

        .title {
            float: right;
        }

        .title p {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            //padding: 5px 0 5px 15px;
            //border: 1px solid #EEE
        }

        .tabletitle {
            font-size: 12px;
            background: #EEE;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .item {
            width: 24mm;
        }

        .itemtext {
            font-size: 12px;
        }

        #legalcopy {
            margin-top: 5mm;
        }
    }
</style>
