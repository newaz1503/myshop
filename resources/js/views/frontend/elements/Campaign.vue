<template>
    <section id="tody_deal">
        <div class="container">
            <div class="row" v-if="campaigns && Object.keys(campaigns).length > 0">
                <div class="col-lg-6 col-sm-12" v-for="(campaign, index) in campaigns" :key="index">
                    <div class="card card-height-100 bg-transparent shadow-none">
                        <div class="card-header align-items-center d-flex title_shape  px-0 py-2 mb-3">
                            <div class="row w-100 align-items-center">
                                <div class="col-lg-6 col-xs-7 col-sm-6">
                                    <h4 class="card-title todays_deal_title">{{ campaign.title }}</h4>
                                </div>
                                <div class="col-lg-4 px-0 col-xs-5 col-sm-6">
                                    <Countdown :deadline="changeDateFormat(campaign.last_date)"></Countdown>
                                </div>
                                <div class="col-lg-2 pe-0 text-end">
                                    <router-link
                                        class="text-muted"
                                        :to="{name:'campaignsdetails', params:{id:campaign.id}}"
                                        >
                                        View All
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div class="row gap-0 position-relative" v-if="campaign.products && Object.keys(campaign.products).length > 0">
                            <div class="col-lg-12 col-xxl-6 col-xl-6 col-sm-6 col-md-4 col-xs-6" v-for="(product,pkey) in campaign.products" :key="pkey" v-if="pkey < 8">
                                <HorizontalProduct :product="product"></HorizontalProduct>
                            </div>
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
        name: "Campaign",
        components: { Countdown },
        data(){
            return{
                campaigns:[]
            }
        },
        methods:{
            getCampagns(){
                axios.get('get-campaigns').then(res => {
                    this.campaigns = res.data;
                })
            },
            changeDateFormat(date){
                let newDate = moment(date).format('LL');
                return newDate;
            }
        },

       async created() {
           await this.getCampagns();
        }
    }
</script>

