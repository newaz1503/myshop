<template>
    <section id="tody_deal" class="py-4">
        <div class="container">
            <div class="row" v-if="campaigndetails && Object.keys(campaigndetails).length > 0">
                <div class="col-lg-12 col-sm-12" v-for="(campaign, index) in campaigndetails" :key="index">
                    <div class="card card-height-100 bg-transparent shadow-none">
                        <div class="card-header align-items-center d-flex title_shape  px-0 py-2 mb-3">
                            <div class="row w-100 align-items-center">
                                <div class="col-lg-4 col-xs-6 col-sm-6 col-sm-6">
                                    <h4 class="card-title todays_deal_title text-truncate">{{ campaign.title }}</h4>
                                </div>
                                <div class="col-lg-4 px-0 col-xs-5 col-sm-3 col-xs-3 text-center">
                                    <Countdown :deadline="changeDateFormat(campaign.last_date)"></Countdown>
                                </div>

                            </div>
                        </div>
                        <div class="row gap-0 position-relative campaign_pages_product"
                             v-if="campaign.products && Object.keys(campaign.products).length > 0">
                            <div class="col-lg-12 col-xxl-3 col-xl-3 col-sm-6 col-md-3 col-xs-6"
                                 v-for="(product,pkey) in campaign.products" :key="pkey" >
                                <HorizontalProduct :product="product"></HorizontalProduct>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="row pt-3">
                <div class="col-lg-8 col-sm-8 m-auto">
                    <div class="text-center">
                        <div class="not_found_image">
                            <img :src="$root.baseurl+'/public/frontend/images/not-found.jpg'" class="img-fluid rounded" alt="" width="220" height="120">
                        </div>
                        <h3 class="text-center mt-3">No campaign Avaiable</h3>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
import Countdown from 'vuejs-countdown';
import moment from 'moment';

export default {
    name: "CampaignsDetails",
    components: {Countdown},
    data() {
        return {
            campaigndetails: []
        }
    },
    mounted() {

        axios.get('get-campaign-details/'+this.$route.params.id).then((response) => {
            this.campaigndetails = response.data;
        }).catch((error) => {
            console.log(error)
        })

    },
    methods:{
        changeDateFormat(date) {
            let newDate = moment(date).format('LL');
            return newDate;
        }
    }

    }

</script>

<style scoped>

</style>
