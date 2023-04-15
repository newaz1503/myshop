<template>
    <section id="category_page">
        <div class="container">
            <div class="card bg-transparent shadow-none mb-0">
                <div class="card-header align-items-center d-flex title_shape   ps-0">
                    <h4 class="card-title mb-0 flex-grow-1 ps-0">Top Category</h4>
                    <div class="flex-shrink-0">
                        <router-link :to="{name:'categories'}"
                            class="text-muted">
                            View All
                        </router-link>
                    </div>
                </div>
                <div class="card  bg-transparent shadow-none mb-0">
                    <div class="card-body pe-0 ps-0">
                        <div class="row" v-if="data.categories && Object.keys(data.categories).length > 0">
                            <div v-for="(category,index) in data.categories" :key="index" class="category_item" >
                                <div class="card shadow-sm ">
                                    <router-link :to="{name:'products', query:{category: category.slug}}">
                                        <img
                                            class="card-img-top img-fluid p-2"
                                            :src="category.image"
                                            alt="Card image cap">
                                        <div class="card-body pt-0 pb-0">
                                            <h4 class="card-title mb-2 text-center  text-truncate">
                                                {{ category.title }} 
                                            </h4>
                                        </div>
                                    </router-link>
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
        name: "TopCategories",
        data() {
            return {
                data: {
                    categories: [],
                },
            }
        },
        async created() {
            await this.get_data('top-categories', 'categories');
        }
    }
</script>

<style scoped>

</style>
