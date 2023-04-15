<template>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Top Sale Products</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table
                            class="table table-hover table-centered align-middle table-nowrap mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Quantity Sold</th>

                            </tr>
                            </thead>
                            <tbody v-if="reportData && Object.keys(reportData).length > 0">
                            <tr v-for="(data, index) in reportData" :key="index">
                                <td>
                                    {{ index+1}}
                                </td>
                                <td>
                                    <img :src=" data.featured_image " alt="" class="topsale-image">
                                </td>
                                <td>
                                    {{ data.name}}
                                </td>
                                <td>
                                    <h5 class="fs-14 my-1 fw-normal">{{ data.sale_count}}</h5>
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
            reportData: []
        }
    },
    mounted(){
        axios.get('admin-topsale').then((response)=>{
            this.reportData=response.data;
        }).catch((error)=>{
            console.log(error)
        })
    },

}
</script>

<style scoped>
.topsale-image{
    height:60px;
    width:60px;
}
</style>
