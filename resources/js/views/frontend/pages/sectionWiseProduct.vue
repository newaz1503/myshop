<template>
  <section id="product-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card card-height-100 mb-0 bg-transparent shadow-none">
                    
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
    name: "sectionWiseProduct",
    data() {
        return {
            products: []
        }
    },
    mounted(){
        axios.get('/sectionwiseproduct/'+this.$route.params.slug).then(res => {
            this.products = res.data;
        }).catch(error => {
            console.log(error);
        })
    }

}
</script>

<style>

</style>
