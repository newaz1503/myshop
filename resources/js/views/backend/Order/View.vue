<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Order #{{ data.invoice_id }}</h5>
                            <div class="flex-shrink-0 d-flex gap-2 align-items-center">
                                <a href="" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                                <AddOrBackButton
                                    :route="model + '.index'"
                                    :portion="model"
                                    :icon="'arrow-left'"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle table-borderless mb-0">
                                <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Product Details</th>
                                    <th scope="col">Item Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col" class="text-end">Total Amount</th>
                                </tr>
                                </thead>
                                <tbody v-if="data.order_details && Object.keys(data.order_details).length > 0">
                                <tr v-for="(details,dindex) in data.order_details" :key="dindex">
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                <img :src="details.product.featured_image" alt="" class="img-fluid d-block">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15"><a href="apps-ecommerce-product-details.html" class="link-primary">{{ details.product.name }}</a></h5>
                                                <p class="text-muted mb-0">Color: <span class="fw-medium">Pink</span></p>
                                                <p class="text-muted mb-0">Size: <span class="fw-medium">M</span></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ details.price | currency }}</td>
                                    <td>{{ details.quantity }}</td>
                                    <td class="fw-medium text-end">
                                        {{ details.total_price | currency}}
                                    </td>
                                </tr>
                                <tr class="border-top border-top-dashed">
                                    <td colspan="3"></td>
                                    <td colspan="2" class="fw-medium p-0">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                            <tr>
                                                <td>Sub Total :</td>
                                                <td class="text-end">{{ data.sub_total | currency}}</td>
                                            </tr>
                                            <tr>
                                                <td>Discount :</td>
                                                <td class="text-end">{{ data.product_discount | currency }}</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charge :</td>
                                                <td class="text-end">{{ data.shipping_cost | currency}}</td>
                                            </tr>
                                            <tr>
                                                <td>Tax :</td>
                                                <td class="text-end">{{ data.tax | currency}}</td>
                                            </tr>
                                            <tr>
                                                <td>Vat :</td>
                                                <td class="text-end">{{ data.vat | currency}}</td>
                                            </tr>
                                            <tr class="border-top border-top-dashed">
                                                <th scope="row">Total (USD) :</th>
                                                <th class="text-end">{{ data.grand_total | currency}}</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3" v-if="data.customer && Object.keys(data.customer).length > 0">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img :src="data.customer.avatar" alt="" class="avatar-sm rounded">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1 text-truncate">{{ data.customer.name }}</h6>
                                        <p class="text-muted mb-0">Customer</p>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ data.customer.email }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ data.customer.mobile }}</li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address</h5>
                    </div>
                    <div class="card-body" v-if="data.customer && Object.keys(data.customer.shipping_info).length > 0">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14">
                                {{ data.customer.shipping_info.shipping_type }}
                            </li>
                            <li>{{ data.customer.shipping_info.mobile }}</li>
                            <li>{{ data.customer.shipping_info.address }}</li>
                            <li>
                                {{ data.customer.shipping_info.city ? data.customer.shipping_info.city.name : ''}} -
                                {{ data.customer.shipping_info.postal_code }}
                            </li>
                            <li>{{ data.customer.shipping_info.country ? data.customer.shipping_info.country.name :''  }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Transactions:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">#VLZ124561278124</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Payment Method:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Debit Card</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Card Holder Name:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Joseph Parker</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Card Number:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">xxxx xxxx xxxx 2456</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Total Amount:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">$415.96</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
    </div>
</template>

<script>
// define model name
const model = "order";

export default {
  data() {
    return {
      model: model,
      data: []
    };
  },
  async created() {
    await this.get_data(this.model, this.$route.params.id, "data"); // get data
    this.setBreadcrumbs(this.model, "view"); // Set Breadcrumbs
  }
};
</script>
