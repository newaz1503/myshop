<template>
    <section id="servicepart">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 service_top mt-4">
                    <div class="card crm-widget bg-transparent shadow-none">
                        <div class="card-body p-0 bg-transparent">
                            <div class="row" v-if="data.services && Object.keys(data.services).length> 0">
                                <div class="col-lg-6 col-xl-6 col-xxl-3 mt-3" v-for="(service,index) in data.services" :key="index">
                                    <div class="py-4  px-3 bg-white">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img height="40" width="40" :src="service.image" alt="">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h3 class="mb-0 text-muted fs-18">
                                                    {{ service.title }}
                                                </h3>
                                                <h5 class="text-muted text-uppercase fs-10 pt-2">
                                                    {{ service.description }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Services",
        data(){
            return{
                data: {
                    services: [],
                },
            }
        },
        methods:{

        },
        async created() {
            await this.get_data('services', 'services');
        }
    }
</script>

<style scoped>

</style>
