<template>
    <section id="latest_product">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card card-height-100 mb-0 bg-transparent shadow-none">
                    <div class="card-header border-0">
                        <div class="row g-4">
                            <div class="col-sm-auto d-flex align-items-center">
                                <div>
                                    <h4>Track Order</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <form  @submit.prevent="trackorder">
            <div class="col-md-12 pt-5">
                <div class="search">
                    <i class="fa fa-search"></i>
                        <input type="text" v-model="form.invoice" class="form-control" placeholder="Enter Invoice">
                        <button type="submit" class="btn btn-outline-success  border bg-color text-white">Search</button>
                </div>
            </div>
            </form>
            <!-- Bootstrap Order Track -->
            <template>
                <div class="pt-5" v-show="showreport">
                <article class="card">
                    <header class="card-header"> My Orders / Tracking </header>
                    <div class="card-body">
                    <h6>Invoice ID: {{ trackreport.invoice_id }}</h6>
            <div class="track">
                <template v-if="trackreport.order_status==='placed_order'">
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Placed</span>
                </div>
                </template>

                <template v-else-if="trackreport.order_status==='pending'">
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Placed</span>
                </div>
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Pending</span>
                </div>
                </template>
                <template v-else-if="trackreport.order_status==='approved'">
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Placed</span>
                </div>
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Pending</span>
                </div>
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Approved</span>
                </div>
                </template>
                <template v-else-if="trackreport.order_status==='delivered'">
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Placed</span>
                </div>
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Pending</span>
                </div>
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Approved</span>
                </div>
                <div class="step active">
                    <span class="icon"> <i class="ri-check-line"></i> </span> <span class="text">Order Delivered</span>
                </div>
                </template>
                <template v-else-if="trackreport.order_status==='cancel'">
                <div class="step active">
                    <span class="icon"> <i class="ri-close-line"></i> </span> <span class="text">Order Canceled</span>
                </div>
                </template>
                <template v-else-if="trackreport.order_status==='hold'">
                <div class="step active">
                    <span class="icon"> <i class="ri-pause-circle-line"></i> </span> <span class="text">Order On Hold</span>
                </div>
                </template>
            </div>

        </div>
    </article>
            </div>
            </template>

            <!-- If there is no result -->
            <template>
                <div class="pt-5" v-show="showerror">
                <article class="card">
                    <header class="card-header"> My Orders / Tracking </header>
                    <div class="card-body">
                    <h6>Invoice ID: Invalid</h6>
            <div class="pt-4">
               <h3>
                No Data Found. Please check your Invoice ID.
               </h3>
            </div>

        </div>
    </article>
            </div>
            </template>

            <!-- End Order track -->
        </div>
    </div>
    </section>
</template>

<script>
    export default {
        name: "trackorder",
        data(){
        return {
            form:{
                invoice:'',
            },
            trackreport:[],
            showreport: false,
            showerror:false,


        }
    },



    methods:{
        trackorder(){
            axios.post('/user/trackorder',this.form).then((response)=>{
                console.log(response);
                if(response.data.success != false){
                this.showreport=true;
                this.showerror=false;
                this.trackreport=response.data;
                this.notification("Order Tracked !!!", "success");
                }else{
                    this.showreport=false;
                    this.showerror=true;
                    this.notification("Invalid Invoice !!!", "error");
                }


            }).catch((error)=>{
                console.log(error)
            })
        }
    },

    }

</script>

<style scoped>
.search{
       position: relative;
       box-shadow: 0 0 40px rgba(51, 51, 51, .1);

       }

       .search input{

        height: 60px;
        text-indent: 25px;
        border: 2px solid #d6d4d4;


       }


       .search input:focus{

        box-shadow: none;
        border: 2px solid blue;


       }

       .search .fa-search{

        position: absolute;
        top: 20px;
        left: 16px;

       }

       .search button{

        position: absolute;
        top: 5px;
        right: 5px;
        height: 50px;
        width: 110px;
        background: blue;

       }
       .track{position: relative;background-color: #ddd;height: 7px;display: -webkit-box;display: -ms-flexbox;display: flex;margin-bottom: 60px;margin-top: 50px}.track .step{-webkit-box-flex: 1;-ms-flex-positive: 1;flex-grow: 1;width: 25%;margin-top: -18px;text-align: center;position: relative}.track .step.active:before{background: #FF5722}.track .step::before{height: 7px;position: absolute;content: "";width: 100%;left: 0;top: 18px}.track .step.active .icon{background: #ee5435;color: #fff}.track .icon{display: inline-block;width: 40px;height: 40px;line-height: 40px;position: relative;border-radius: 100%;background: #ddd}.track .step.active .text{font-weight: 400;color: #000}.track .text{display: block;margin-top: 7px}.itemside{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;width: 100%}.itemside .aside{position: relative;-ms-flex-negative: 0;flex-shrink: 0}.img-sm{width: 80px;height: 80px;padding: 7px}ul.row, ul.row-sm{list-style: none;padding: 0}.itemside .info{padding-left: 15px;padding-right: 7px}.itemside .title{display: block;margin-bottom: 5px;color: #212529}p{margin-top: 0;margin-bottom: 1rem}.btn-warning{color: #ffffff;background-color: #ee5435;border-color: #ee5435;border-radius: 1px}.btn-warning:hover{color: #ffffff;background-color: #ff2b00;border-color: #ff2b00;border-radius: 1px}

</style>
