<template>
    <section id="banner" class="hero_section_1">
        <div class="container  position-relative">
            <div class="row ms-0 position-inherit">
                <div class="col-lg-3 col-xl-3 col-xxl-2 px-0 position-inherit">
                    <ul class="bg-white slider-navbar p-sm-0 me-sm-10">
                        <li class="pb-3 pt-3 ps-15 h4 text-white bg-color " data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> <i
                                class="las la-align-justify"></i> All Categories</li>
                        <div class="collapse d-lg-block d-md-none d-xl-none d-xxl-none" id="collapseExample">
                            <div class="card card-body p-lg-0">
                                <template v-if="data.categories && Object.keys(data.categories).length > 0">
                                    <li v-for="(category, index ) in data.categories" :key="index"
                                        class="list-group-item list-group-fill-primary  border-bottom-0    border-bottom-0 mega-menu-item position-inherit">
                                        <router-link :to="{ name: 'products', query: { category: category.slug } }"
                                            class="position-inherit sidebar_ancor">
                                        <span class="text-truncate category_title">
                                            <img :src="category.image" height="20" width="20" alt="">
                                             {{ category.title }}>
                                        </span>
                                            <i class="bx bx-chevron-right" v-if="category.sub_categories && Object.keys(category.sub_categories).length > 0"></i>
                                        </router-link>
                                        <div v-if="category.sub_categories && Object.keys(category.sub_categories).length > 0"
                                            class="mega mega-menu-hover-content meta_menu_content position-absolute top-0  text-white start-0 bg-white w-84 h-100 z-index-999 flex-wrap overflow-hidden overflow-scroll">
                                            <div class="d-flex flex-wrap">
                                                <div class="subcategory w-33"
                                                    v-for="(child, cindex) in category.sub_categories" :key="cindex">
                                                    <ul class="list-unstyled mb-3">
                                                        <li class="fw-600 text-dark border-bottom pb-2 mb-3">
                                                            <router-link
                                                                :to="{ name: 'products', query: { category: child.slug } }">
                                                                <span class="text-truncate category_title">
                                                                    <img :src="child.image" height="20" width="20" alt="">
                                                                     {{ child.title }}
                                                                </span>
                                                            </router-link>
                                                        </li>
                                                        <template
                                                            v-if="child.child_categories && Object.keys(child.child_categories).length > 0">
                                                            <li v-for="(subChild, sindex) in child.child_categories"
                                                                :key="sindex" class="border-bottom-0 fs-12">
                                                                <router-link class="child_category"
                                                                    :to="{ name: 'products', query: { category: subChild.slug } }">
                                                                    <span class="text-truncate category_title">
                                                                        <img :src="subChild.image" height="20" width="20" alt="">
                                                                        {{ subChild.title }}
                                                                    </span>
                                                                </router-link>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="h4">
                                    <router-link :to="{ name: 'categories' }" class="position-inherit sidebar_ancor text-truncate">
                                                    <span><i class=" bx bx-category"></i>
                                                    See All</span>
                                    </router-link>
                                </li>
                                </template>
                            </div>
                        </div>
                        <div class="d-sm-none d-xs-none d-lg-none d-xl-block">
                            <template v-if="data.categories && Object.keys(data.categories).length > 0">
                                <li v-for="(category, index ) in data.categories" :key="index"
                                    class="list-group-item list-group-fill-primary  border-bottom-0    border-bottom-0 mega-menu-item position-inherit">
                                    <router-link :to="{ name: 'products', query: { category: category.slug } }"
                                        class="position-inherit sidebar_ancor">
                                        <span class="text-truncate category_title">
                                        <img :src="category.image" height="20" width="20" alt="">
                                       {{ category.title }}
                                    </span>
                                    <i class="bx bx-chevron-right" v-if="category.sub_categories && Object.keys(category.sub_categories).length > 0"></i>
                                    </router-link>
                                    <div v-if="category.sub_categories && Object.keys(category.sub_categories).length > 0"
                                        class="mega mega-menu-hover-content meta_menu_content position-absolute top-0  text-white start-0 bg-white w-84 h-100 z-index-999 flex-wrap overflow-hidden overflow-scroll">
                                        <div class="d-flex flex-wrap">
                                            <div class="subcategory w-33"
                                                v-for="(child, cindex) in category.sub_categories" :key="cindex">
                                                <ul class="list-unstyled mb-3">
                                                    <li class="fw-600 text-dark border-bottom  pb-2 mb-3">
                                                        <router-link class="sub_category_item"
                                                            :to="{ name: 'products', query: { category: child.slug } }">
                                                            <span class="text-truncate category_title">
                                                                <img :src="child.image" height="20" width="20" alt="">
                                                                {{ child.title }}
                                                            </span>
                                                        </router-link>
                                                    </li>
                                                    <template
                                                        v-if="child.child_categories && Object.keys(child.child_categories).length > 0">
                                                        <li v-for="(subChild, sindex) in child.child_categories"
                                                            :key="sindex" class="border-bottom-0">
                                                            <router-link class="child_category"
                                                                :to="{ name: 'products', query: { category: subChild.slug } }">
                                                                <span class="text-truncate category_title">
                                                                    <img :src="subChild.image" height="20" width="20" alt="">
                                                                    {{ subChild.title }}
                                                                </span>
                                                            </router-link>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="h4">
                                <router-link :to="{ name: 'categories' }" class="position-inherit sidebar_ancor text-truncate">
                                                <i class=" bx bx-category"></i>
                                                See All
                                </router-link>
                            </li>
                            </template>
                        </div>

                    </ul>
                </div>
                <div class="col-lg-6 col-xl-6 col-xxl-7 ps-xs-0 ps-sm-0 ps-lg-15 ps-xl-15 ps-xxl-25">
                    <div class="card-body">
                        <VueSlickCarousel v-bind="sliderSettings"
                            v-if="data.sliders && Object.keys(data.sliders).length > 0">
                            <router-link class="slider-image" to="campaigns" v-for="(slider, skey) in data.sliders" :key="skey">
                                <img v-if="slider.slider" class="d-block img-fluid mx-auto w-100 h-lg-100 h-xxl-100 h-xl-100"
                                    :src="slider.slider" :alt="slider.title">
                                <template v-else>
                                    <div class="placeholder-glow">
                                        <div class="placeholder slider-image"></div>
                                    </div>
                                </template>
                            </router-link>
                        </VueSlickCarousel>
                        <template v-else>
                            <div class="placeholder-glow">
                                <div class="placeholder slider-image"></div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-12 col-xxl-3 banner_right_6 d-lg-block col-lg-3 d-xl-block d-xxl-block banner_right_side">
                    <!-- Swiper -->
                    <router-link to="campaigns">
                        <div class="card h-lg-44 h-xl-46" v-if="$root.global.first_banner">
                                <img class="card-img-top img-fluid border-radius-2  h-xl-100 h-lg-100" :src="$root.global.first_banner"
                                alt="Card image cap">
                        </div>
                      </router-link>

                       <router-link to="campaigns">
                            <div class="card h-lg-44 h-xl-46" v-if="$root.global.second_banner">
                                <img class="card-img-top img-fluid border-radius-2 h-xl-100  h-lg-100" :src="$root.global.second_banner"
                                    alt="Card image cap">
                            </div>
                     </router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    name: "HeroSection",
    components: { VueSlickCarousel },
    data() {
        return {
            data: {
                sliders: [],
                categories: [],
            },
            sliderSettings: {
                "dots": false,
                "dotsClass": "slick-dots custom-dot-class",
                "edgeFriction": 0.35,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 1,
                "slidesToScroll": 1,
                "autoplay": true,
                "autoplaySpeed": 2000,

                "responsive": [
                    {
                        "breakpoint": 1024,
                        "settings": {
                            "slidesToShow": 1,
                            "slidesToScroll": 1,
                            "infinite": true,
                            "dots": false
                        }
                    },
                    {
                        "breakpoint": 767,
                        "settings": {
                            "slidesToShow": 1,
                            "slidesToScroll": 1,
                            "arrows": false,
                        }
                    },
                    {
                        "breakpoint": 576,
                        "settings": {
                            "slidesToShow": 1,
                            "slidesToScroll": 1,
                            "arrows": false,
                        }
                    }
                ]
            },
        }
    },
    async created() {
        await this.get_data('sliders', 'sliders');
        await this.get_data('banner-categories-8', 'categories');
    }
}
</script>

