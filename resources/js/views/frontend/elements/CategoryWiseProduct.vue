<template>
    <section id="tody_deal">
        <div class="container">
            <div class="card card-height-100 bg-transparent shadow-none">
                <div class="card-header align-items-center d-flex title_shape  p-xs-10  ps-0">
                    <h4 class="card-title mb-0 flex-grow-1 ps-0">{{ sectionTitle }}</h4>
                    <div class="flex-shrink-0">
                        <router-link :to="{name:'categories'}"
                            class="text-muted">
                            View All
                        </router-link>
                    </div>
                </div>
                <div class="row mt-3">
                    <!-- category loop -->
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" v-if="categoryOne && Object.keys(categoryOne).length > 0">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <div
                                    class="card-header bg-color text-white align-items-center d-flex title_shape p-xs-10  ps-3">
                                    <h4 class=" text-white card-title mb-0 flex-grow-1">{{ categoryOne.title }}</h4>
                                    <div class="flex-shrink-0">
                                        <router-link :to="{name:'products',query:{'category':categoryOne.slug}}"
                                            class="text-white">
                                            View All
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <template v-show="categoryOne.products && Object.keys(categoryOne.products).length > 0">
                                <div class="col-lg-12 col-md-4 col-sm-6 col-xs-6" v-for="(product,index) in categoryOne.products" :key="index">
                                    <HorizontalProduct :product="product"></HorizontalProduct>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12" v-if="categoryTwo && Object.keys(categoryTwo).length > 0">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <div
                                    class="card-header bg-color text-white align-items-center d-flex title_shape   p-xs-10 ps-3">
                                    <h4 class=" text-white card-title mb-0 flex-grow-1">{{ categoryTwo.title }}</h4>
                                    <div class="flex-shrink-0">
                                        <router-link
                                            class="text-white"
                                            :to="{name:'products',query:{'category':categoryTwo.slug}}"
                                            >
                                            View All
                                        </router-link>
                                    </div>
                                </div>
                            </div>

                            <template v-show="categoryTwo.products && Object.keys(categoryTwo.products).length > 0">
                                <div class="col-lg-12 col-md-4 col-xs-6 col-sm-6" v-for="(product,index) in categoryTwo.products" :key="index">
                                    <HorizontalProduct :product="product"></HorizontalProduct>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12" v-if="categoryThree && Object.keys(categoryThree).length > 0">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <div
                                    class="card-header bg-color text-white align-items-center d-flex title_shape  p-xs-10 ps-3">
                                    <h4 class=" text-white card-title mb-0 flex-grow-1">{{ categoryThree.title }}</h4>
                                    <div class="flex-shrink-0">
                                        <router-link
                                            class="text-white"
                                            :to="{name:'products',query:{'category':categoryThree.slug}}"
                                          >
                                            View All
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <template v-show="categoryThree.products && Object.keys(categoryThree.products).length > 0">
                                <div class="col-lg-12 col-md-4 col-sm-6 col-xs-6" v-for="(product,index) in categoryOne.products" :key="index">
                                    <HorizontalProduct :product="product"></HorizontalProduct>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- category loop end -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "CategoryWiseProduct",
        data(){
            return{
                sectionTitle:'',
                categoryOne: {},
                categoryTwo: {},
                categoryThree: {},
            }
        },

        async created(){
            await axios.get('category-product').then(res => {
                this.sectionTitle   = res.data.popular_section_title;
                this.categoryOne    = res.data.popular_category_one;
                this.categoryTwo    = res.data.popular_category_two;
                this.categoryThree  = res.data.popular_category_three;
            }).catch(error => {
                console.log(error)
            })
        }
    }
</script>

<style scoped>

</style>
