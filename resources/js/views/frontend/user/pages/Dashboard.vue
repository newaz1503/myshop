<template>
    <div class="user-dashboard">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="ri-bar-chart-fill align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    Total Order
                                </p>
                                <h4 class=" mb-0">
                                    <span class="counter-value">
                                        {{ statistics.total_order }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span
                                    class="avatar-title bg-light text-success rounded-circle fs-3">
                                    <i class="ri-alarm-warning-fill align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Total Pending Order</p>
                                <h4 class=" mb-0">
                                    <span class="counter-value">
                                        {{ statistics.order_pending }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span
                                    class="avatar-title bg-light text-info rounded-circle fs-3">
                                    <i class="ri-alert-fill align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    Total Cancel Order
                                </p>
                                <h4 class=" mb-0">
                                    <span class="counter-value">{{ statistics.order_cancel  }}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Recent Order History</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table
                                class="table table-hover table-centered align-middle table-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice Id</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody v-if="recentOrders && Object.keys(recentOrders).length > 0">
                                <tr v-for="(recentOrder, index) in recentOrders" :key="index">
                                    <td>
                                        {{ index+1}}
                                    </td>
                                    <td>
                                        {{ recentOrder.invoice_id}}
                                    </td>
                                    <td>
                                        {{ recentOrder.total_quantity}}
                                    </td>
                                    <td>
                                        {{ recentOrder.grand_total}}
                                    </td>
                                    <td>
                                        <span class="text-capitalize badge badge-soft-success">
                                            {{ recentOrder.order_status}}
                                        </span>
                                    </td>
                                    <td>
                                        {{ recentOrder.created_at | formatDate}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                statistics: [],
                totalOrders: [],
                pendingOrders: [],
                canceledOrders: [],
                search: "",
                recentOrders: [],
            }
        },
        mounted() {

            // One Url for All Order status
            axios.get('user/order-statistics').then((response) => {
                this.statistics = response.data;
            }).catch((error) => {
                console.log(error)
            })

            // Order History
            axios.get('user/recent-order').then((response) => {
                this.recentOrders = response.data;
            }).catch((error) => {
                console.log(error)
            })


            // Canceled Order History
            axios.get('user/canceled-order').then((response) => {
                this.canceledOrders = response.data;
            }).catch((error) => {
                console.log(error)
            })

        },
        methods: {},
    };
</script>

