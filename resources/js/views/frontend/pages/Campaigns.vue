<template>
    <section id="tody_deal" class="py-4">
        <div class="container">
            <div class="row" v-if="campaigns && Object.keys(campaigns).length > 0">
                <div class="col-lg-12 col-sm-12" v-for="(campaign, index) in campaigns" :key="index">
                    <div class="card card-height-100 bg-transparent shadow-none">
                        <div class="card-header align-items-center d-flex title_shape  px-0 py-2 mb-3">
                            <div class="row w-100 align-items-center">
                                <div class="col-lg-4 col-xs-6 col-sm-6 col-sm-6">
                                    <h4 class="card-title todays_deal_title text-truncate">{{ campaign.title }}</h4>
                                </div>
                                <div class="col-lg-4 px-0 col-xs-5 col-sm-3 col-xs-3 text-center">
                                    <Countdown :deadline="changeDateFormat(campaign.last_date)"></Countdown>
                                </div>
                                <div class="col-lg-4 pe-0 col-xs-3 col-sm-3 text-end">
                                    <router-link :to="{name:'campaignsdetails', params:{id:campaign.id}}"
                                                 class=" py-1  text-muted">view all</router-link>


                                </div>
                            </div>
                        </div>
                        <div class="row gap-0 position-relative campaign_pages_product"
                             v-if="campaign.products && Object.keys(campaign.products).length > 0">
                            <div class="col-lg-12 col-xxl-3 col-xl-3 col-sm-6 col-md-3 col-xs-6"
                                 v-for="(product,pkey) in campaign.products" :key="pkey" v-if="pkey < 8">
                                <HorizontalProduct :product="product"></HorizontalProduct>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div v-else class="row pt-3">
                <div class="col-lg-12 bg-white" v-if="!is_loading">
                    <div class="row justify-content-center py-5">
                        <div class="col-lg-6 text-center">
                            <img :src="$root.baseurl+'/public/frontend/images/not-found.jpg'" class="img-fluid rounded" alt="" width="220" height="120">
                            <h5>No Campaign Available!</h5>
                        </div>
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
    name: "Campaigns",
    components: {Countdown},
    data() {
        return {
            campaigns: [],
            is_loading: false,
        }
    },
    methods: {
        getCampagns() {
            axios.get('get-campaigns').then(res => {
                this.campaigns = res.data;
            })
        },
        changeDateFormat(date) {
            let newDate = moment(date).format('LL');
            return newDate;
        }
    },
    async created() {
        await this.getCampagns();
    }
}
</script>

<style scoped>

</style>
