<template>
    <section id="products_page" class="mt-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex mb-3 m-xs-0 m-sm-0 m-md-0">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <h5 class="fs-16">Filters</h5>
                                    <div id="mobile_side_bar" class="d-xxl-none d-xl-none d-lg-none d-md-block d-sm-block d-xs-block">
                                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas_product_filter" aria-labelledby="offcanvas_product_filterLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="offcanvas_product_filterLabel">
                                            Product Filters
                                            </h5>
                                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <div class="accordion accordion-flush filter-accordion">
                                        <div class="card-body border-bottom">
                                            <div>
                                                <p class="text-muted text-uppercase fs-12 fw-medium mb-2">Categories</p>
                                                <ul class="list-unstyled mb-0 filter-list"
                                                    v-if="categories && Object.keys(categories).length > 0">
                                                    <li v-for="(category, ckey) in categories" :key="ckey">
                                                        <router-link :to="{name:'products', query:{category:category.slug}}"
                                                        :class="search.category_id == category.id ? 'active':''"
                                                        class="d-flex py-1 align-items-center"
                                                        >
                                                            <div class="flex-grow-1 gap-2 d-flex align-items-center">
                                                                <img :src="category.image" height="20" width="20" alt="">
                                                                <h5 class="fs-13 mb-0 listname">{{ category.title }}</h5>
                                                            </div>
                                                            <div class="flex-shrink-0 ms-2">
                                                                <span class="badge bg-light text-muted">{{ category.productCount }}</span>
                                                            </div>
                                                        </router-link>
                                                        <ul class="mb-0 ps-4 child-category" v-if="category && Object.keys(category.child_categories).length > 0">
                                                            <li v-for="(childCat,chindex) in category.child_categories" :key="chindex">
                                                                <router-link :to="{name:'products', query:{category:childCat.slug}}"
                                                                            class="d-flex py-1 align-items-center"
                                                                >
                                                                    <div class="flex-grow-1">
                                                                        <h5 class="fs-13 mb-0 listname">{{ childCat.title }}</h5>
                                                                    </div>
                                                                    <div class="flex-shrink-0 ms-2">
                                                                        <span class="badge bg-light text-muted">{{ childCat.productCount }}</span>
                                                                    </div>
                                                                </router-link>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="card-body border-bottom">
                                            <p class="text-muted text-uppercase fs-12 fw-medium mb-4">Price</p>
                                            <form method="get" @submit.prevent="getProducts">
                                                <div class="formCost d-flex gap-2 align-items-center mt-3">
                                                    <input name="min" v-model="search.from_price"
                                                        class="form-control form-control-sm" type="text" id="minCost"
                                                    >
                                                    <span class="fw-semibold text-muted">to</span>
                                                    <input name="max" v-model="search.to_price" class="form-control form-control-sm"
                                                        type="text" id="maxCost"
                                                    >
                                                    <button type="submit" class="btn btn-sm bg-color  text-white">Apply</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingBrands">
                                                <button class="accordion-button bg-transparent shadow-none" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseBrands"
                                                        aria-expanded="true" aria-controls="flush-collapseBrands">
                                                    <span class="text-muted text-uppercase fs-12 fw-medium">Brands</span> <span
                                                    class="badge bg-color rounded-pill align-middle ms-1 filter-badge"></span>
                                                </button>
                                            </h2>

                                            <div id="flush-collapseBrands" class="accordion-collapse collapse show"
                                                aria-labelledby="flush-headingBrands">
                                                <div class="accordion-body text-body pt-0">
                                                    <div class="d-flex flex-column gap-2 mt-3 filter-check">
                                                        <template v-if="brands && Object.keys(brands).length > 0">
                                                            <div class="form-check" v-for="(brand,bkey) in brands" :key="bkey">
                                                                <input v-model="search.brand_id" class="form-check-input" type="checkbox" :value="brand.id"
                                                                    :id="`productBrand${bkey}`">
                                                                <label class="form-check-label" :for="`productBrand${bkey}`">{{ brand.name }}</label>
                                                            </div>
                                                        </template>
                                                        <div>
                                                            <button @click="getBrands('loadall')" type="button"
                                                                    class="btn btn-sm bg-color  text-white fw-medium">
                                                            Load More
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion-item -->

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingDiscount">
                                                <button class="accordion-button bg-transparent shadow-none" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseDiscount"
                                                        aria-expanded="true" aria-controls="flush-collapseDiscount">
                                                    <span class="text-muted text-uppercase fs-12 fw-medium">Discount</span> <span
                                                    class="badge bg-color rounded-pill align-middle ms-1 filter-badge"></span>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseDiscount" class="accordion-collapse collapse show"
                                                aria-labelledby="flush-headingDiscount" style="">
                                                <div class="accordion-body text-body pt-1">
                                                    <div class="d-flex flex-column gap-2 filter-check">
                                                        <div class="form-check">
                                                            <input v-model="search.dicount_percent" class="form-check-input" type="checkbox" value="50% or more"
                                                                id="productdiscountRadio6">
                                                            <label class="form-check-label" for="productdiscountRadio6">50% or
                                                                more</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.dicount_percent" class="form-check-input" type="checkbox" value="40% or more"
                                                                id="productdiscountRadio5">
                                                            <label class="form-check-label" for="productdiscountRadio5">40% or
                                                                more</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.dicount_percent" class="form-check-input" type="checkbox" value="30% or more"
                                                                id="productdiscountRadio4">
                                                            <label class="form-check-label" for="productdiscountRadio4">
                                                                30% or more
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.dicount_percent" class="form-check-input" type="checkbox" value="20% or more"
                                                                id="productdiscountRadio3" checked="">
                                                            <label class="form-check-label" for="productdiscountRadio3">
                                                                20% or more
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.dicount_percent" class="form-check-input" type="checkbox" value="10% or more"
                                                                id="productdiscountRadio2">
                                                            <label class="form-check-label" for="productdiscountRadio2">
                                                                10% or more
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.dicount_percent" value="" class="form-check-input" type="checkbox" value="Less than 10%"
                                                                id="productdiscountRadio1">
                                                            <label class="form-check-label" for="productdiscountRadio1">
                                                                Less than 10%
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion-item -->

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingRating">
                                                <button class="accordion-button bg-transparent shadow-none" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseRating"
                                                        aria-expanded="true" aria-controls="flush-collapseRating">
                                                    <span class="text-muted text-uppercase fs-12 fw-medium">Rating</span> <span
                                                    class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                                </button>
                                            </h2>

                                            <div id="flush-collapseRating" class="accordion-collapse collapse show"
                                                aria-labelledby="flush-headingRating" style="">
                                                <div class="accordion-body text-body">
                                                    <div class="d-flex flex-column gap-2 filter-check">
                                                        <div class="form-check">
                                                            <input v-model="search.ratings" class="form-check-input" type="checkbox"
                                                                value="4" id="productratingRadio4" checked="">
                                                            <label class="form-check-label" for="productratingRadio4">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 4 &amp; Above
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.ratings" class="form-check-input" type="checkbox"
                                                                value="3" id="productratingRadio3">
                                                            <label class="form-check-label" for="productratingRadio3">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 3 &amp; Above
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.ratings" class="form-check-input" type="checkbox"
                                                                value="2" id="productratingRadio2">
                                                            <label class="form-check-label" for="productratingRadio2">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 2 &amp; Above
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input v-model="search.ratings" class="form-check-input" type="checkbox" value="1"
                                                                id="productratingRadio1">
                                                            <label class="form-check-label" for="productratingRadio1">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 1
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion-item -->
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="hstack flex-wrap gap-2">
                            <button class="btn btn-light d-xxl-none d-xl-none d-lg-none d-md-block d-sm-block d-xs-block" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_product_filter" aria-controls="offcanvas_product_filter">
                                <i class=" ri-filter-2-line"></i>
                            </button>
                        </div>
                                    <a @click="clearSearch" href="javascript:" class="text-decoration-underline d-xxl-block d-xl-block d-lg-block d-md-none d-sm-none d-xs-none" id="clearall">Clear All</a>
                                </div>
                            </div>
                        </div>

                        <div class="accordion accordion-flush filter-accordion d-xxl-block d-xl-block d-lg-block d-md-none d-sm-none d-xs-none">
                            <div class="card-body border-bottom" id="category_custom_height">
                                <div>
                                    <p class="text-muted text-uppercase fs-12 fw-medium mb-2">Categories</p>
                                    <ul class="list-unstyled mb-0 filter-list"
                                        v-if="categories && Object.keys(categories).length > 0">
                                        <li v-for="(category, ckey) in categories" :key="ckey">
                                            <router-link :to="{name:'products', query:{category:category.slug}}"
                                               :class="search.category_id == category.id ? 'active':''"
                                               class="d-flex py-1 align-items-center"
                                            >
                                                <div class="flex-grow-1 gap-2 d-flex align-items-center">
                                                    <img :src="category.image" height="20" width="20" alt="">
                                                    <h5 class="fs-13 mb-0 listname">{{ category.title }}</h5>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <span class="badge bg-light text-muted">{{ category.productCount }}</span>
                                                </div>
                                            </router-link>
                                            <ul class="mb-0 ps-4 child-category" v-if="category && Object.keys(category.child_categories).length > 0">
                                                <li v-for="(childCat,chindex) in category.child_categories" :key="chindex">
                                                    <router-link :to="{name:'products', query:{category:childCat.slug}}"
                                                                 class="d-flex py-1 align-items-center"
                                                    >
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-13 mb-0 listname">{{ childCat.title }}</h5>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-2">
                                                            <span class="badge bg-light text-muted">{{ childCat.productCount }}</span>
                                                        </div>
                                                    </router-link>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body border-bottom">
                                <p class="text-muted text-uppercase fs-12 fw-medium mb-4">Price</p>
                                <form method="get" @submit.prevent="getProducts">
                                    <div class="formCost d-flex gap-2 align-items-center mt-3">
                                        <input name="min" v-model="search.from_price"
                                               class="form-control form-control-sm" type="text" id="minCost"
                                        >
                                        <span class="fw-semibold text-muted">to</span>
                                        <input name="max" v-model="search.to_price" class="form-control form-control-sm"
                                               type="text" id="maxCost"
                                        >
                                        <button type="submit" class="btn btn-sm bg-color  text-white">Apply</button>
                                    </div>
                                </form>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingBrands">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseBrands"
                                            aria-expanded="true" aria-controls="flush-collapseBrands">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Brands</span> <span
                                        class="badge bg-color rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseBrands" class="accordion-collapse collapse show"
                                     aria-labelledby="flush-headingBrands">
                                    <div class="accordion-body text-body pt-0">
                                        <div class="d-flex flex-column gap-2 mt-3 filter-check">
                                            <template v-if="brands && Object.keys(brands).length > 0">
                                                <div class="form-check" v-for="(brand,bkey) in brands" :key="bkey">
                                                    <input v-model="search.brand_id" class="form-check-input" type="checkbox" :value="brand.id"
                                                           :id="`productBrand${bkey}`">
                                                    <label class="form-check-label" :for="`productBrand${bkey}`">{{ brand.name }}</label>
                                                </div>
                                            </template>
                                            <div>
                                                <button @click="getBrands('loadall')" type="button"
                                                        class="btn btn-sm bg-color  text-white fw-medium">
                                                   Load More
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion-item -->

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingDiscount">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseDiscount"
                                            aria-expanded="true" aria-controls="flush-collapseDiscount">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Discount</span> <span
                                        class="badge bg-color rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>
                                <div id="flush-collapseDiscount" class="accordion-collapse collapse show"
                                     aria-labelledby="flush-headingDiscount" style="">
                                    <div class="accordion-body text-body pt-1">
                                        <div class="d-flex flex-column gap-2 filter-check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="50% or more"
                                                       id="productdiscountRadio6">
                                                <label class="form-check-label" for="productdiscountRadio6">50% or
                                                    more</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="40% or more"
                                                       id="productdiscountRadio5">
                                                <label class="form-check-label" for="productdiscountRadio5">40% or
                                                    more</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="30% or more"
                                                       id="productdiscountRadio4">
                                                <label class="form-check-label" for="productdiscountRadio4">
                                                    30% or more
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="20% or more"
                                                       id="productdiscountRadio3" checked="">
                                                <label class="form-check-label" for="productdiscountRadio3">
                                                    20% or more
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="10% or more"
                                                       id="productdiscountRadio2">
                                                <label class="form-check-label" for="productdiscountRadio2">
                                                    10% or more
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Less than 10%"
                                                       id="productdiscountRadio1">
                                                <label class="form-check-label" for="productdiscountRadio1">
                                                    Less than 10%
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion-item -->

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingRating">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseRating"
                                            aria-expanded="true" aria-controls="flush-collapseRating">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Rating</span> <span
                                        class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>

                                <div id="flush-collapseRating" class="accordion-collapse collapse show"
                                     aria-labelledby="flush-headingRating" style="">
                                    <div class="accordion-body text-body">
                                        <div class="d-flex flex-column gap-2 filter-check">
                                            <div class="form-check">
                                                <input v-model="search.ratings" class="form-check-input" type="checkbox"
                                                       value="4" id="productratingRadio4" checked="">
                                                <label class="form-check-label" for="productratingRadio4">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 4 &amp; Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input v-model="search.ratings" class="form-check-input" type="checkbox"
                                                       value="3" id="productratingRadio3">
                                                <label class="form-check-label" for="productratingRadio3">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 3 &amp; Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input v-model="search.ratings" class="form-check-input" type="checkbox"
                                                       value="2" id="productratingRadio2">
                                                <label class="form-check-label" for="productratingRadio2">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 2 &amp; Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input v-model="search.ratings" class="form-check-input" type="checkbox" value="1"
                                                       id="productratingRadio1">
                                                <label class="form-check-label" for="productratingRadio1">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 1
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion-item -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-9 col-lg-8">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link fw-semibold">
                                                Total Product Found<span
                                                class="badge badge-soft-danger align-middle rounded-pill ms-1">{{ totalProduct }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-auto">
                                    <div id="selection-element" style="display: none;">
                                        <div class="my-n1 d-flex align-items-center text-muted">
                                            Select
                                            <div id="select-content" class="text-body fw-semibold px-1"></div>
                                            Result
                                            <button type="button" class="btn btn-link link-danger p-0 ms-3"
                                                    data-bs-toggle="modal" data-bs-target="#removeItemModal">Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box w-100 ms-2">
                                            <input v-model="search.product_name" type="text" class="form-control" id="searchProductList"
                                                   placeholder="Search Products...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card header -->

                        <div class="card-body ps-0 pe-0">
                            <template v-if="products && Object.keys(products).length > 0">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-6" v-for="(product,pkey) in products"
                                         :key="pkey">
                                        <Product :product="product"></Product>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="col-lg-12 bg-white" v-if="!is_loading">
                                    <div class="row justify-content-center py-5">
                                        <div class="col-lg-6 text-center">
                                            <img class="img-fluid"
                                                 :src="$root.baseurl+'/frontend/images/no-product-img.png'" alt="">
                                            <h5>No Product Available!</h5>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Product from "../components/Product";
    export default {
        name: "Products",
        components: {Product},
        data() {
            return {
                is_loading:false,
                totalProduct: null,
                products: [],
                brands: [],
                categories: [],
                search: {
                    brand_id: [],
                    ratings: [],
                    product_name: '',
                    from_price: 1,
                    to_price: 1000000
                },
            }
        },
        watch: {
            $route:{
                handler() {
                    this.getProducts();
                },
                deep: true,
                immediate: true,
            },
            search:{
                handler() {
                    this.getProducts();
                },
                deep: true,
                immediate: true,
            },
        },
        methods: {
            clearSearch(){
                this.search = {
                    brand_id: [],
                    product_name: '',
                    from_price: 1,
                    to_price: 1000000
                };
                this.$router.push({name:'products'})
            },
            getProducts() {
                this.is_loading = true;
                $('#preloader').fadeIn(10);
                this.search.query_params = this.$route.query;
                axios.get('get-products', {params: this.search}).then(res => {
                    this.products = res.data.products;
                    this.totalProduct = res.data.countProduct;
                }).catch(error => {
                    console.log(error);
                }).finally(() => {
                    setTimeout(() => {
                        this.is_loading = false;
                        $('#preloader').fadeOut('slow');
                    }, 1000);
                })
            },
            getBrands(loadall = null){
                let limit = 8;
                if (loadall){
                    limit = "all"
                }
                axios.get('get-brands',{params: {limit: limit}}).then(res => {
                    this.brands = res.data;
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        async created() {
            // await this.getProducts();
            await axios.get('parent-categories').then(res => {
                this.categories = res.data;
            }).catch(error => {
                console.log(error)
            });
            await this.getBrands();
        }


    }
</script>
<style lang="scss" scoped>
    .child-category{
        list-style: circle;
    }
    #category_custom_height{
        max-height: 350px;
        overflow: auto;
    }
     ::-webkit-scrollbar {
       width: 5px;
       background: transparent;
    }
    ::-webkit-scrollbar-thumb{
        background: #dfdfdf;
        width: 4px;
        border-radius: 5px;
    }
</style>
