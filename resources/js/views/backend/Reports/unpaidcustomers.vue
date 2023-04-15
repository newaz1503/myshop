<template>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Unpaid Customers</h4>
                    <div class="col-sm">
                        <div class="d-flex justify-content-sm-end">
                            <div class="search-box ms-2">
                                <input type="text" class="form-control" v-model="searchTerm"
                                       placeholder="Search with Date...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
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
                                <th>Invoice ID</th>
                                <th>Customer Name</th>
                                <th>Mobile NO</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                                <th>Date</th>

                            </tr>
                            </thead>
                            <tbody v-if="unpaidCustomers && Object.keys(unpaidCustomers).length > 0">
                            <tr v-for="(data, index) in filtersearch" :key="index">
                                <td>
                                    {{ index+1}}
                                </td>
                                <td>
                                    {{data.invoice_id}}
                                </td>
                                <td>
                                    {{ data.name}}
                                </td>
                                <td>
                                    <h5 class="fs-14 my-1 fw-normal">{{ data.mobile}}</h5>
                                </td>
                                <td>
                                    <h5 class="fs-14 my-1 fw-normal">${{ data.grand_total}}</h5>
                                </td>
                                <td>
                                    {{ data.payment_status}}
                                </td>
                                <td>
                                    {{ data.day}}
                                </td>

                            </tr>
                            </tbody>
                        </table>
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
            unpaidCustomers: [],
            searchTerm: ''
        }
    },
    computed:{
        filtersearch(){
            return this.unpaidCustomers.filter(data=>{
                return data.name.match(this.searchTerm)
            })
        }
    },
    mounted(){

        axios.get('unpaid-customers').then((response)=>{
            this.unpaidCustomers = response.data
        }).catch((error)=>{
            console.log(error)
        })
    },

}
</script>

<style scoped>

</style>
