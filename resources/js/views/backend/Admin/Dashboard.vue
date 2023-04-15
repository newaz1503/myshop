<template>
    <div v-if="!$root.spinner" class="row">
        <div class="col-xl-8">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card card-animate orders animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="la la-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">Orders</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.total_order}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card card-animate unpaid animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="las la-exclamation-triangle"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">Unpaid
                                            Order</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.paid_order}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <!-- card -->
                    <div class="card card-animate delivered animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="las la-clipboard-check"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">
                                            Delivered</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.delivered_order}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <!-- card -->
                    <div class="card card-animate tobe_delivered animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="la la-newspaper-o"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">Pending
                                            Order</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.holding_order}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <!-- card -->
                    <div class="card card-animate sales animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="la la-bar-chart"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">Total
                                            Sale</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">
                                            ${{statistics.total_sale}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <!-- card -->
                    <div class="card card-stats paid animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="las la-receipt"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">POS
                                            Invoice</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.pos_invoice}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <!-- card -->
                    <div class="card card-animate customers animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="la la-users "></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase stat-title fw-medium mb-0 text-white ">
                                            Customers</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.total_customer}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card card-animate products animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="lab la-product-hunt"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">
                                            Products</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.total_products}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card card-animate visitors animate-round-shape">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="lab la-product-hunt"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center ps-0">
                                    <div class="numbers">
                                        <p class="text-uppercase fw-medium text-white text-truncate mb-0">
                                            Total Visitors</p>
                                        <h4 class="fs-30 fw-semibold ff-secondary text-white mb-4">{{
                                            statistics.visitors}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="h-100">
                <div class="card card-body py-5 text-center">
                    <apexchart
                        type="donut"
                        :options="chartOptions"
                        :series="series"
                    >
                    </apexchart>
                    <p>Sale Stats of <span class="fw-bold">{{chartMonth}}</span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Recent Orders From Store</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Qty</th>
                                    <!--                                    <th scope="col">Sub Total</th>-->
                                    <th scope="col">Grand Total</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(order, index) in ordersSite" :key="index">
                                    <td>
                                        {{ index+1 }}
                                    </td>
                                    <td>
                                        <a href="" class="fw-medium link-primary">{{ order.invoice_id }}</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                            </div>
                                            <div class="flex-grow-1">{{ order.customer.name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-danger">{{ order.payment_status }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">{{ order.order_status }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-info">{{ order.total_quantity }}</span>
                                    </td>
                                    <!--                                    <td>-->
                                    <!--                                        <span class="text-success">${{ order.sub_total }}</span>-->
                                    <!--                                    </td>-->

                                    <td>
                                        <span class="text-danger ">${{ order.grand_total }}</span>
                                    </td>

                                    <td>
                                        <span class="text-success">{{ order.created_at | formatDate }}</span>
                                    </td>

                                </tr><!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Recent Orders From POS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Invoice ID</th>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Sub Total</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Grand Total</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(orderpos, index) in ordersPos" :key="index">
                                    <td>
                                        {{ index+1 }}
                                    </td>
                                    <td>
                                        <a href="" class="fw-medium link-primary">{{ orderpos.invoice_id }}</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                            </div>
                                            <div class="flex-grow-1">{{ orderpos.barcode }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-danger">{{ orderpos.sub_total }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">{{ orderpos.total_quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-info">{{ orderpos.grand_total }}</span>
                                    </td>
                                    <td>
                                        <span class="text-success">{{ orderpos.created_at | formatDate }}</span>
                                    </td>

                                </tr><!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
        </div>
    </div>
</template>
<script>
    import VueApexCharts from 'vue-apexcharts'
    const breadcrumb = [{route: "admin.dashboard", title: "Dashboard"}];
    export default {
        components: {
            apexchart: VueApexCharts,
        },
        data() {
            return {
                menus: [],
                statistics: [],
                ordersSite: [],
                ordersPos: [],
                chartSite: '',
                chartPos: '',
                chartMonth: '',
                totalSale: '',
                series: [0, 0],
                chartOptions: {
                    chart: {
                        width: 200,
                        type: 'donut',
                    },
                    legend: {
                        position: 'bottom'
                    },
                    labels: ['POS Orders', 'Store Orders'],
                },

            };
        },
        mounted() {
            axios.get('admin-order-statistics').then((response) => {
                this.statistics = response.data;
            }).catch((error) => {
                console.log(error)
            })
            // Admin Order Report
            axios.get('admin-order-report').then((response) => {
                this.ordersSite = response.data;
            }).catch((error) => {
                console.log(error)
            })
            //     Admin POS Order Report
            axios.get('admin-pos-order-report').then((response) => {
                this.ordersPos = response.data;
            }).catch((error) => {
                console.log(error)
            })
            // Pie Chart Data
            axios.get('admin-month-chart').then((response) => {
                this.chartMonth = response.data.current_date;
                this.series = [response.data.pos_invoice, response.data.site_invoice];
            }).catch((error) => {
                console.log(error)
            })
        },
        created() {
            breadcrumbs.dispatch("setBreadcrumbs", breadcrumb);
        }
    };
</script>
<style lang="scss" scoped>
    .btn .badge {
        position: absolute;
    }

    .btn.btn-app {
        width: 105px;
        font-size: 12px;
        white-space: inherit;
        height: 90px;
    }

    .unpaid {
        background-color: #FF646D;
    }

    .paid {
        background-color: #59D05D;
    }

    .delivered {
        background-color: #ff80ed;
    }

    .tobe_delivered {
        background-color: #ff7373;
    }

    .sales {
        background-color: #FBAD4C;
    }

    .orders {
        background-color: #1D62F0;
        overflow: hidden;
    }

    .customers {
        background-color: #66cdaa;
    }

    .products {
        background-color: #ff1493;
    }
    .visitors {
        background-color: #9bb03f;
    }

    .icon-big {
        font-size: 3em;
        min-height: 64px;
        i {
            color: white !important;
        }
    }
    .month-name {
        padding-left: 80px;
    }
    .animate-round-shape {
        position: relative;
        overflow: hidden;
        &:after {
            content: '';
            position: absolute;
            top: 0px;
            left: -23px;
            height: 48px;
            width: 101px;
            background: #ffffff42;
            border: 1px solid #ffffff12;
            filter: brightness(0.9);
            border-radius: 50px;
            transform: rotate(45deg);
        }
    }
</style>
