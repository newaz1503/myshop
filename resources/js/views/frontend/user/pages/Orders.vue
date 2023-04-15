<template>
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header  border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Order History</h5>
                    <div class="flex-shrink-0">

                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form @submit.prevent="getOrders">
                    <div class="row g-3 align-items-center">
                        <div class="col-xxl-4 col-sm-4">
                            <div class="search-box mt-4">
                                <input type="text" class="form-control search" v-model="search_data.value"
                                       placeholder="Enter Order ID">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-3">
                            <div>
                                <label for="">From Date</label>
                                <input v-model="search_data.from_date" type="date" name="from_date" class="form-control" placeholder="Select date">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-3">
                            <div>
                                <label for="">To Date</label>
                                <input type="date" v-model="search_data.to_date" name="to_date" class="form-control" placeholder="Select date">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-2">
                            <div class="mt-4">
                                <button type="submit" class="btn bg-color text-white w-100"><i
                                    class="ri-equalizer-fill me-1 align-bottom"></i>
                                    Filters
                                </button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="orderTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Delivery Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="list form-check-all">
                        <tr v-for="(order, index) in table.datas" :key="index">
                            <td class="id">
                                <router-link :to="{name:'user.order.invoice', params:{id:order.invoice_id}}" class="fw-medium link-primary">{{
                                    order.invoice_id }}
                                </router-link>
                            </td>

                            <td class="date">{{ order.created_at | formatDate }}</td>
                            <td class="amount">{{ order.grand_total }}</td>
                            <td class="payment">{{ order.payment_method }}</td>
                            <td class="status"><span class="badge badge-soft-warning text-uppercase">{{ order.order_status }}</span>
                            </td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        data-bs-placement="top" aria-label="View" data-bs-original-title="View">
                                        <router-link :to="{name:'user.order.invoice', params:{id:order.invoice_id}}" class="text-primary d-inline-block">

                                            <span>View Order</span>
                                        </router-link>
                                    </li>
                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal"
                                           href="#deleteOrder">

                                            <span>Delete Order</span>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <div class="mt-4 text-center">
                                                <h4>You are about to delete a order ?</h4>
                                                <p class="text-muted fs-15 mb-4">Deleting your order will remove all of
                                                    your information from our database.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button
                                                        class="btn btn-link link-success fw-medium text-decoration-none"
                                                        id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                        class="ri-close-line me-1 align-middle"></i> Close
                                                    </button>
                                                    <button class="btn btn-danger" :id="order.id"
                                                            @click="OrderRemove(order.id)">Yes, Delete It
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->
                        </tr>
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <h5 class="mt-2">Sorry! No Result Found</h5>
                            <p class="text-muted">We've searched more than 150+ Orders We did not find any orders for
                                you search.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="pagination-wrap hstack gap-2">
                        <Pagination
                            :routeName="'user.orders'"
                            :url="'user/allorders'"
                            v-if="!$root.spinner"
                            :search_data="search_data"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Pagination from "../../../../components/frontend/Pagination";
    export default {
        name: "Orders",
        components: {Pagination},
        data() {
            return {
                search_data: {
                    pagination: 10,
                    field_name: 'invoice_id',
                    value: "",
                    from_date: "",
                    to_date: ""
                },
                table: {
                    routes: {},
                    datas: [],
                    meta: [],
                    links: []
                },
                orders: [],
                searchOrder: '',
            }
        },
        computed: {
            filtersearch() {
                return this.orders.filter(order => {
                    return order.invoice_id.match(this.searchOrder)
                })
            }
        },
        mounted() {
            // All Orders
            this.getOrders();
        },
        methods: {
            getOrders(){
                axios.get('user/allorders',{params:this.search_data}).then((response) => {
                    this.table['datas'] = response.data.data;
                    this.table['meta'] = response.data.meta;
                    this.table['links'] = response.data.links;
                }).catch((error) => {
                    console.log(error)
                })
            },
            OrderRemove(id) {
                console.log(id);
                axios.post('user/removeOrder/' + id).then((response) => {
                    if (response.data.success == true) {
                        this.notification("Order Deleted Successfully !!!", "success");
                        // this.$router.push({name:'wishlist'});
                         window.location.reload();
                    }
                }).catch((error) => {
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>

</style>
