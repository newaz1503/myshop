<template>
    <section id="band_page">
        <div class="container">
            <div class="card mb-0 bg-transparent shadow-none">
                <div class="card-header align-items-center d-flex  title_shape  ps-0">
                    <h4 class="card-title mb-0 flex-grow-1 ps-0">Top Brands</h4>
                    <div class="flex-shrink-0">
                        <router-link :to="{name:'brands'}"
                            class="text-muted">
                            View All
                        </router-link>
                    </div>
                </div>
                <div class="card mb-0 bg-transparent shadow-none">
                    <div class="card-body ps-0 pe-0 mb-0">
                        <div class="row" v-if="data.brands && Object.keys(data.brands).length > 0">
                            <div class="brand_item" v-for="(brand,index) in data.brands" :key="index">
                                <router-link :to="{name:'products',query:{brand: brand.slug}}">
                                    <div class="card shadow-sm">
                                        <img
                                            class="img-thumbnail img-fluid border-0 p-0 "
                                            alt="200x200"
                                            :src="brand.icon">
                                    </div>
                                </router-link>
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
        name: "Brands",
        data() {
            return {
                data: {
                    brands: [],
                },
            }
        },
        async created() {
            await this.get_data('top-brands', 'brands');
        }
    }
</script>

<style scoped>

</style>
