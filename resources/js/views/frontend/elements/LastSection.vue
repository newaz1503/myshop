<template>
    <section id="tody_deal">
        <div class="container">
            <div class="card card-height-100 bg-transparent shadow-none">
                <div class="card-header align-items-center d-flex  ps-0  title_shape ">
                    <h4 class="card-title mb-0 flex-grow-1">{{ sectionTitle }}</h4>
                    <div class="flex-shrink-0">
                            <router-link :to="{name:'sectionWiseProduct', params:{slug: slug }, query:{product:makeSlug(sectionTitle)}}" class="text-muted">
                                    View All
                                </router-link>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-lg-3 d-flex  mb-3" v-if="$root.global && $root.global.last_banner">
                       <div class="h-100 w-100 banner-bg-image bg-cover">

                       </div>

                    </div>
                    <div class="col-lg-9">
                        <div class="row" v-show="products && Object.keys(products).length > 0">
                            <div class=" col-xl-4 col-xxl-4 col-lg-6 col-md-4 col-sm-6 col-xs-6" v-for="(product,index) in products" :key="index">
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
    export default {
        props: {
            sectionTitle: String,
            products: Array,
            slug: String,
        },
        name: "LastSection",
        methods:{
            makeSlug(title){
                var slug = title.toLowerCase().replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
            return slug;
            },
        }
    }
</script>

<style scoped>

</style>
