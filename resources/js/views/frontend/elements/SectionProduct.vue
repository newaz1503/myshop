<template>
    <section id="product-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card card-height-100 mb-0 bg-transparent shadow-none">
                        <div class="card-header align-items-center d-flex title_shape  ps-0">
                            <h4 class="card-title mb-0 flex-grow-1 ps-0 ">{{ sectionTitle }}</h4>
                            <div class="flex-shrink-0">
                                <router-link :to="{name:'sectionWiseProduct', params:{slug: slug }, query:{product:makeSlug(sectionTitle)}}" class="text-muted">
                                    View All
                                </router-link>
                            </div>
                        </div>
                        <div class="card-body pb-0  ps-0 pe-0">
                            <div class="row" v-show="products && Object.keys(products).length > 0">
                                <div class="col-xl-2 col-xxl-2 col-lg-3 col-sm-6 col-md-4  col-xs-6" v-for="(product,index) in products" :key="index">
                                    <Product :product="product"></Product>
                                </div>
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
        name: "SectionProduct",
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
