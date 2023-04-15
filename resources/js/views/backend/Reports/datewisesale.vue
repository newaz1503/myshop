<template>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Date Wise Sales Report</h4>
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
                                <th>Date</th>
                                <th>Sold Invoices</th>
                                <th>Total Sales</th>
                            </tr>
                            </thead>
                            <tbody v-if="saleData && Object.keys(saleData).length > 0">
                            <tr v-for="(data, index) in filtersearch" :key="index">
                                <td>
                                    {{ index+1}}
                                </td>
                                <td>
                                    {{ data.day}}
                                </td>
                                <td>
                                    <h5 class="fs-14 my-1 fw-normal">{{ data.sale_count}}</h5>
                                </td>
                                <td>
                                    <h5 class="fs-14 my-1 fw-normal"> {{$root.settings.currency}}{{ data.total_sale}}</h5>
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
            saleData: [],
            searchTerm: ''
        }
    },
    computed:{
        filtersearch(){
            return this.saleData.filter(data=>{
                return data.day.match(this.searchTerm)
            })
        }
    },
    mounted(){
        axios.get('date-wise-sale').then((response)=>{
            this.saleData=response.data;
        }).catch((error)=>{
            console.log(error)
        })

    },

}
</script>

<style scoped>

</style>
