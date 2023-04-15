<template>
    <section id="band_page" class="mt-4">
        <div class="container">
            <div class="card bg-transparent shadow-none">
                <div class="card-header p-xs-10 border-0 ">
                    <div class="row g-4">
                        <div class="col-sm-auto d-flex align-items-center col-xs-6">
                            <div>
                                <h4>All Brand</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-transparent shadow-none">
                    <div class="card-body ps-0 pe-0">
                        <div class="row" v-if="brands.length > 0">
                            <div class="brand_item" v-for="(brand, key) in brands" :key="key">
                                <router-link :to="{name:'products', query:{brand:brand.slug}}">
                                    <div class="card mb-xs-10 shadow-sm">
                                        <img
                                            class="img-thumbnail img-fluid border-0 p-0"
                                            alt="200x200"
                                            :src="brand.icon">
                                    </div>
                                </router-link>
                            </div>
                        </div>
                         <div v-else class="row pt-3">
                            <div class="col-lg-12 bg-white" v-if="!is_loading">
                                <div class="row justify-content-center py-5">
                                    <div class="col-lg-6 text-center">
                                        <img :src="$root.baseurl+'/public/frontend/images/not-found.jpg'" class="img-fluid rounded" alt="" width="220" height="120">
                                        <h5>No Brand Available!</h5>
                                    </div>
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
        name: "Brands",
        data(){
            return{
                brands: [],
            }
        },
       async mounted(){
           await this.allBrands();
        },
        methods: {
            allBrands(){
                axios.get('/allbrands')
                .then( response => {
                    this.brands = response.data
                })
                .catch(e => {
                    console.log(e);
                })
            }
        }
    }
</script>

<style scoped>

</style>
