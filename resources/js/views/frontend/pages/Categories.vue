<template>
    <section id="category_page" class="mt-4">
        <div class="container">
            <div class="card bg-transparent shadow-none mb-0">
                <div class="card-header border-0">
                    <div class="row g-4">
                        <div class="col-sm-auto col-xs-6 d-flex align-items-center">
                            <div>
                                <h4>All Category</h4>
                            </div>
                        </div>
                        <div class="col-sm col-xs-6">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control" id="searchProductList"
                                           placeholder="Search Brand...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card  bg-transparent shadow-none mb-0">
                    <div class="card-body pe-0 ps-0">
                        <div class="row" v-if="categories.length > 0">
                            <div class="category_item" v-for="(category, key) in categories" :key="key">
                                <div class="card shadow-sm ">
                                    <router-link  :to="{name:'products', query:{category:category.slug}}">
                                        <img class="card-img-top img-fluid p-2" v-if="category.image" :src="category.image"
                                             alt="Card image cap">
                                             <div class="card-body pt-0 pb-0">
                                            <h4 class="card-title mb-2 text-center  text-truncate" v-if="category.title">{{category.title}}</h4>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                         <div v-else class="row pt-3">
                            <div class="col-lg-12 bg-white" v-if="!is_loading">
                                <div class="row justify-content-center py-5">
                                    <div class="col-lg-6 text-center">
                                        <img :src="$root.baseurl+'/public/frontend/images/not-found.jpg'" class="img-fluid rounded" alt="" width="220" height="120">
                                        <h5>No Category Available!</h5>
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
        name: "Categories",
        data(){
            return{
                categories : [],
            }
        },
        async mounted(){
           await this.allcategories();
        },
        methods:{
           async allcategories(){
               await axios.get('/all-categories')
                .then(response => {
                    this.categories = response.data
                })
                .catch(e =>{
                    console.log(e);
                })
            }
        }
    }
</script>

<style scoped>

</style>
