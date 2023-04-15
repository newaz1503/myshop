<template>
    <div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3">
                <!-- card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                            <span
                                                class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                <i class="ri-bar-chart-fill align-middle"></i>
                                            </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    Registered Orders</p>
                                <h4 class=" mb-0"><span class="counter-value"
                                                        data-target="">{{ registeredOrders + registeredOrdersSale }}</span></h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
            <div class="col-xl-3 col-lg-3 col-md-3">
                <!-- card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                            <i class="ri-alarm-warning-fill align-middle"></i>
                                                        </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    POS Orders</p>
                                <h4 class=" mb-0"><span class="counter-value"
                                                        data-target="2390.68">{{ walkingOrders }}</span></h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->

            <!-- end col -->
            <div class="col-xl-3 col-lg-3 col-md-3">
                <!-- card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                            <i class="bx bx-wallet align-middle"></i>
                                                        </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    Registered Sales</p>
                                <h4 class=" mb-0"><span class="counter-value"
                                                        data-target="2390.68">{{ registeredSales + registeredPosAmount }}</span></h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
            <div class="col-xl-3 col-lg-3 col-md-3">
                <!-- card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                            <i class="bx bx-wallet align-middle"></i>
                                                        </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    Walking Sales</p>
                                <h4 class=" mb-0"><span class="counter-value"
                                                        data-target="2390.68">{{walkingSales[0]['walking_sale']}}</span></h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->

        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"> Registered Customers From Site</h4>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">

                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table
                                class="table table-hover table-centered align-middle table-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>name</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody v-if="registered && Object.keys(registered).length > 0">
                                <tr v-for="(data, index) in filtersearch" :key="index">
                                    <td>
                                        {{ index+1}}
                                    </td>
                                    <td>
                                        {{ data.invoice_id}}
                                    </td>
                                    <td>
                                        <h5 class="fs-14 my-1 fw-normal">{{ data.name}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="fs-14 my-1 fw-normal">${{ data.mobile}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="fs-14 my-1 fw-normal">${{ data.grand_total}}</h5>
                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Walking Customers</h4>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">

                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table
                                class="table table-hover table-centered align-middle table-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Barcode</th>
                                    <th>Grand Total</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody v-if="walking && Object.keys(walking).length > 0">
                                <tr v-for="(data, index) in walking" :key="index">
                                    <td>
                                        {{ index+1}}
                                    </td>
                                    <td>
                                        {{ data.invoice_id}}
                                    </td>
                                    <td>
                                        <h5 class="fs-14 my-1 fw-normal">{{ data.barcode}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="fs-14 my-1 fw-normal">${{ data.grand_total}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="fs-14 my-1 fw-normal">{{ data.day}}</h5>
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
            registered: [],
            walking: [],
            registeredOrders:[],
            registeredOrdersSale:[],
            walkingOrders:[],
            registeredSales:[],
            walkingSales:[],
            registeredPosAmount:[],
            searchTerm: ''
        }
    },
    computed:{
        filtersearch(){
            return this.registered.filter(data=>{
                return data.name.match(this.searchTerm)
            })
        }
    },
    mounted(){
        axios.get('customer-typewise-sale').then((response)=>{
            this.registered=response.data.registered;
            this.registeredOrders=(response.data.registered_orders);
            this.registeredOrdersSale=(response.data.registered_orders_sale);
            this.walkingOrders=response.data.walking_orders;
            this.registeredSales=response.data.registered_sale_amount[0]['registered_sale'];
            this.registeredPosAmount=response.data.registered_pos_amount[0]['registered_sale'];
            this.walkingSales=response.data.walking_pos_amount;
            console.log(this.registeredPosAmount)
            this.walking=response.data.walking;
        }).catch((error)=>{
            console.log(error)
        })

    },

}
</script>

<style scoped>

</style>
