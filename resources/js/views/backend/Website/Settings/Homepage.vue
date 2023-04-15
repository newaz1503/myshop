<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Setup Your Home Page</h4>
        </div>
        <div class="card-body form-steps">
            <div class="row gy-5 vertical-navs-step">
                <div class="col-lg-3">
                    <div class="nav flex-column custom-nav nav-pills position-sticky top-20" role="tablist"
                         aria-orientation="vertical">
                        <button class="nav-link active" id="theme-layout-tab" data-bs-toggle="pill"
                                data-bs-target="#theme-layout" type="button" role="tab"
                                aria-controls="theme-layout" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-wallpaper me-2"></i> Theme Layout
                                </span>
                        </button>
                        <button class="nav-link" id="top-header-tab" data-bs-toggle="pill"
                                data-bs-target="#top-header" type="button" role="tab"
                                aria-controls="top-header" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-menu me-2"></i> Top Header
                                </span>
                        </button>
                        <button class="nav-link" id="offer-banner-tab" data-bs-toggle="pill"
                                data-bs-target="#offer-banner" type="button" role="tab"
                                aria-controls="offer-banner" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-file-jpg-box me-2"></i> Offer Banner
                                </span>
                        </button>
                        <button class="nav-link" id="popup-banner-tab" data-bs-toggle="pill"
                                data-bs-target="#popup-banner" type="button" role="tab"
                                aria-controls="popup-banner" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-book-outline me-2"></i> Popup Banner
                                </span>
                        </button>
                        <button class="nav-link" id="category-product-tab" data-bs-toggle="pill"
                                data-bs-target="#category-product" type="button" role="tab"
                                aria-controls="category-product" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-newspaper-variant-outline me-2"></i> Popular Categories
                                </span>
                        </button>

                        <button class="nav-link" id="two-column-banner-tab" data-bs-toggle="pill"
                                data-bs-target="#two-column-banner" type="button" role="tab"
                                aria-controls="two-column-banner" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-view-column-outline me-2"></i> Two Column Banner
                                </span>
                        </button>
                        <button class="nav-link" id="product-section-tab" data-bs-toggle="pill"
                                data-bs-target="#product-section" type="button" role="tab"
                                aria-controls="product-section" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="mdi mdi-view-grid-plus-outline me-2"></i> Product Section
                                </span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="px-lg-4">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="theme-layout" role="tabpanel"
                                 aria-labelledby="theme-layout-tab">
                                <div class="">
                                    <h5>Theme Layout</h5><br>
                                    <form @submit.prevent="saveThemeLayout" id="saveThemeLayout" class="">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4">
                                                <div class="form-check card-radio">
                                                    <input
                                                        id="layout1"
                                                        v-model="data.theme_layout"
                                                        name="theme_layout"
                                                        type="radio"
                                                        value="layout_one"
                                                        class="form-check-input"
                                                    >
                                                    <label class="form-check-label" for="layout1">
                                                        <div class="layout-image">
                                                            <img class="img-fluid" :src="$root.baseurl+'/admin/images/theme-layouts/layout-1.png'" alt="">
                                                            <p class="pt-2 mb-0">Layout One</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-check card-radio">
                                                    <input
                                                        id="layout2"
                                                        v-model="data.theme_layout"
                                                        name="theme_layout"
                                                        type="radio"
                                                        value="layout_two"
                                                        class="form-check-input"
                                                    >
                                                    <label class="form-check-label" for="layout2">
                                                        <div class="layout-image">
                                                            <img class="img-fluid" :src="$root.baseurl+'/admin/images/theme-layouts/layout-1.png'" alt="">
                                                            <p class="pt-2 mb-0">Layout Two</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-check card-radio">
                                                    <input
                                                        id="layout3"
                                                        v-model="data.theme_layout"
                                                        name="theme_layout"
                                                        type="radio"
                                                        value="layout_three"
                                                        class="form-check-input"
                                                    >
                                                    <label class="form-check-label" for="layout3">
                                                        <div class="layout-image">
                                                            <img class="img-fluid" :src="$root.baseurl+'/admin/images/theme-layouts/layout-1.png'" alt="">
                                                            <p class="pt-2 mb-0">Layout Three</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gap-3 mt-4">
                                            <Button type="submit" title="Save Changes"></Button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="top-header" role="tabpanel"
                                 aria-labelledby="top-header-tab">
                                <div>
                                    <h5>Top Header Setting</h5>
                                </div>
                                <form class="row g-3" @submit.prevent="saveTopHeader">
                                    <div class="col-sm-12">
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input type="checkbox" v-model="data.theader_show_track_order" value="1"
                                                   class="form-check-input" name="track_order" id="TrackOrder">
                                            <label class="form-check-label" for="TrackOrder">Track Order</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input type="checkbox" v-model="data.theader_show_help_line" value="1"
                                                   class="form-check-input" name="help_line" id="helptLine">
                                            <label class="form-check-label" for="helptLine">Help Line</label>
                                        </div>
                                        <label>Help line number</label>
                                        <input
                                            v-if="data.theader_show_help_line"
                                            type="number"
                                            name="helpline_number"
                                            class="form-control"
                                            placeholder="Enter Help Line Number"
                                            v-model="data.theader_help_line_number"
                                        >
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">Background Color</label>
                                        <input
                                            type="color"
                                            name="bg_color"
                                            class="form-control"
                                            v-model="data.theader_bg_color"
                                        >
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="form-label">Font Color</label>
                                        <input
                                            type="color"
                                            name="font_color"
                                            class="form-control"
                                            v-model="data.theader_font_color"
                                        >
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <button v-if="!btnLoader" type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">Save
                                            Changes
                                        </button>
                                        <button v-else type="button"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="fa fa-spinner fa-spin"></i> Loading..
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="offer-banner" role="tabpanel"
                                 aria-labelledby="offer-banner-tab">
                                <div>
                                    <h5>Hero Section Offer Banner</h5>
                                </div>
                                <form class="row g-3" @submit.prevent="saveOfferBanner" id="offer-banner-form" enctype="multipart/form-data">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">Top Header Banner</label>
                                            <input
                                                type="file"
                                                accept="image/png, image/gif"
                                                name="top_header_banner"
                                                id="top_header_banner"
                                                @change="imageHandler($event,'top_header_banner')"
                                                class="top_header_banner mb-2"
                                            >
                                            <a v-if="data.top_header_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('top_header_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.top_header_banner" alt="">
                                            <p>Size: (1350 × 50 px)</p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">First Banner</label>
                                            <input
                                                type="file"
                                                name="first_banner"
                                                id="first_image"
                                                @change="imageHandler($event,'first_banner')"
                                                class="first_image mb-2"
                                            >
                                            <a v-if="data.first_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('first_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.first_banner" alt="">
                                            <label class="text-muted mt-2">image size: 316 × 240 px</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">Second Banner</label>
                                            <input
                                                type="file"
                                                name="second_banner"
                                                id="second_image"
                                                @change="imageHandler($event,'second_banner')"
                                                class="second_image mb-2"
                                            >
                                            <a v-if="data.second_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('second_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.second_banner" alt="">
                                            <label class="text-muted mt-2">image size: 316 × 240 px</label>
                                        </div>
                                        <div>
                                            <h5>Last Section Offer Banner</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">Last Banner</label>
                                            <input
                                                type="file"
                                                name="last_banner"
                                                id="last_image"
                                                @change="imageHandler($event,'last_banner')"
                                                class="last_image mb-2"
                                            >
                                            <a v-if="data.last_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('last_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.last_banner" alt="">
                                            <label class="text-muted mt-2">image size: 316 × 240 px</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <button v-if="!btnLoader" type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">Save
                                            Changes
                                        </button>
                                        <button v-else type="button"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="fa fa-spinner fa-spin"></i> Loading..
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="popup-banner" role="tabpanel"
                                 aria-labelledby="popup-banner-tab">
                                <div>
                                    <h5>Home Page Popup Banner</h5>
                                </div>
                                <form class="row g-3" @submit.prevent="savePopupBanner" id="popup-banner-form" enctype="multipart/form-data">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                <input type="checkbox" v-model="data.is_show_popup" value="1"
                                                       class="form-check-input" name="is_show_popup" id="showPopup">
                                                <label class="form-check-label" for="showPopup">Show Popup</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">Popup Banner Image (800 × 500 px)</label>
                                            <input
                                                type="file"
                                                name="popup_banner"
                                                id="popup_banner"
                                                @change="imageHandler($event,'popup_banner')"
                                                class="popup_banner mb-2"
                                            >
                                            <a v-if="data.popup_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('popup_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.popup_banner" alt="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">GIF Banner Image (60 × 60 px)</label>
                                            <input
                                                type="file"
                                                name="gif_banner"
                                                accept=".gif"
                                                id="gif_banner"
                                                @change="imageHandler($event,'gif_banner')"
                                                class="gif_banner mb-2"
                                            >
                                            <a v-if="data.gif_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('gif_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.gif_banner" alt="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">Page URL</label>
                                            <input
                                                v-model="data.popup_page_url"
                                                type="text"
                                                name="popup_page_url"
                                                class="form-control mb-2"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <button v-if="!btnLoader" type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">Save
                                            Changes
                                        </button>
                                        <button v-else type="button"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="fa fa-spinner fa-spin"></i> Loading..
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="category-product" role="tabpanel"
                                 aria-labelledby="category-product-tab">
                                <div>
                                    <h5>Popular Categories</h5>
                                </div>
                                <form class="row g-3" @submit.prevent="savePopularProduct">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Section Title *</label>
                                            <input
                                                v-model="data.popular_section_title"
                                                type="text"
                                                name="section_title"
                                                class="form-control"
                                                placeholder="Enter section title"
                                            >
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">1st | Category</label>
                                            <v-select
                                                :options="categories"
                                                :reduce="category => category.id"
                                                label="title"
                                                v-model="data.popular_category_one"
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">2nd | Category</label>
                                            <v-select
                                                :options="categories"
                                                :reduce="category => category.id"
                                                label="title"
                                                v-model="data.popular_category_two"
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">3rd | Category</label>
                                            <v-select
                                                :options="categories"
                                                :reduce="category => category.id"
                                                label="title"
                                                v-model="data.popular_category_three"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <button v-if="!btnLoader" type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">Save
                                            Changes
                                        </button>
                                        <button v-else type="button"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="fa fa-spinner fa-spin"></i> Loading..
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="two-column-banner" role="tabpanel"
                                 aria-labelledby="two-column-banner-tab">
                                <div>
                                    <h5>Two Column Offer Banner</h5>
                                </div>
                                <form class="row g-3" @submit.prevent="saveTwoColumnBanner" id="two-column-banner-form">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">First Banner</label>
                                            <input
                                                type="file"
                                                name="two_column_first_banner"
                                                id="tcob-first"
                                                @change="imageHandler($event,'two_column_first_banner')"
                                                class="two_column_first_banner mb-2"
                                            >
                                            <a v-if="data.two_column_first_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('two_column_first_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.two_column_first_banner" alt="">
                                            <label class="text-muted mt-2">image size: 40 × 40 px</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">Second Banner</label>
                                            <input
                                                type="file"
                                                name="two_column_second_banner"
                                                id="tcob-second"
                                                @change="imageHandler($event,'two_column_second_banner')"
                                                class="two_column_second_banner mb-2"
                                            >
                                            <a v-if="data.two_column_second_banner" href="javascript:" class="btn btn-danger btn-sm" @click="removeImage('two_column_second_banner')">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                            <img class="img-fluid" :src="data.two_column_second_banner" alt="">
                                            <label class="text-muted mt-2">image size: 40 × 40 px</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <button v-if="!btnLoader" type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">Save
                                            Changes
                                        </button>
                                        <button v-else type="button"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="fa fa-spinner fa-spin"></i> Loading..
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="product-section" role="tabpanel"
                                 aria-labelledby="product-section-tab">
                                <div>
                                    <h5>Section Wise Product</h5>
                                </div>
                                <form class="row g-3" @submit.prevent="saveSectionProduct">
                                    <!-- Section One -->
                                    <div class="col-sm-12">
                                       <h4># Section One</h4>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Title *</label>
                                            <input
                                                v-model="data.section_one_title"
                                                type="text"
                                                name="section_one_title"
                                                class="form-control"
                                                placeholder="Enter section title"
                                            >
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">Products *</label>
                                            <b-form-group
                                                class="w-100 similar-product-selector"
                                                label-for="tags-with-dropdown"
                                            >
                                                <b-form-tags
                                                    id="tags-with-dropdown"
                                                    no-outer-focus
                                                    class="mb-2"
                                                >
                                                    <template v-slot="{ disabled }">
                                                        <b-dropdown
                                                            size="sm"
                                                            variant="outline-light"
                                                            block
                                                            menu-class="w-100 text-start"
                                                        >
                                                            <template #button-content>Select Product</template>
                                                            <b-dropdown-form @submit.stop.prevent="() => {}">
                                                                <b-form-group
                                                                    label="Search product"
                                                                    label-for="tag-search-input"
                                                                    label-cols-md="auto"
                                                                    class="mb-0"
                                                                    label-size="sm"
                                                                    :description="searchDesc"
                                                                    :disabled="disabled"
                                                                    placeholder="type your product name"
                                                                >
                                                                    <b-form-input
                                                                        v-model="search"
                                                                        id="tag-search-input"
                                                                        type="search"
                                                                        size="sm"
                                                                        autocomplete="off"
                                                                    ></b-form-input>
                                                                </b-form-group>
                                                            </b-dropdown-form>
                                                            <b-dropdown-item-button
                                                                v-for="(option, index) in sectionOneAvailableOptions"
                                                                :key="index"
                                                                @click="selectedProduct(option,'section_one_products')"
                                                            >
                                                                <div class="d-flex align-items-center">
                                                                    <img
                                                                        class="mr-2"
                                                                        height="45"
                                                                        :src="option.featured_image"
                                                                        alt
                                                                    />
                                                                    <span>{{ option.name }}</span>
                                                                </div>
                                                            </b-dropdown-item-button>
                                                            <b-dropdown-text v-if="sectionOneAvailableOptions.length === 0">
                                                                There are no product available to select
                                                            </b-dropdown-text>
                                                        </b-dropdown>
                                                        <ul
                                                            v-if="data.section_one_products.length > 0"
                                                            class="list-inline d-inline-block mb-2 selected-product"
                                                        >
                                                            <li
                                                                v-for="(product, index) in data.section_one_products"
                                                                :key="index"
                                                                class="list-inline-item"
                                                            >
                                                                <b-form-tag
                                                                    @remove="removeSelectedProduct(index,'section_one_products')"
                                                                    :title="product.name"
                                                                    variant="light"
                                                                >
                                                                    <div class="d-flex">
                                                                        <img height="30" :src="product.featured_image" alt />
                                                                        <div class="text-start">
                                                                            <h6 class="m-0">
                                                                                {{ product.name }}
                                                                            </h6>
                                                                            <span class="text-red">
                                                                              BDT {{ product.sale_price }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </b-form-tag>
                                                            </li>
                                                        </ul>
                                                    </template>
                                                </b-form-tags>
                                            </b-form-group>
                                        </div>
                                    </div>
                                    <!-- Section Two -->
                                    <div class="col-sm-12">
                                        <h4># Section Two</h4>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Title *</label>
                                            <input
                                                v-model="data.section_two_title"
                                                type="text"
                                                name="section_two_title"
                                                class="form-control"
                                                placeholder="Enter section title"
                                            >
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block">Products</label>
                                            <b-form-group
                                                class="w-100 similar-product-selector"
                                                label-for="tags-with-dropdown"
                                            >
                                                <b-form-tags
                                                    id="tags-with-dropdown"
                                                    no-outer-focus
                                                    class="mb-2"
                                                >
                                                    <template v-slot="{ disabled }">
                                                        <b-dropdown
                                                            size="sm"
                                                            variant="outline-light"
                                                            block
                                                            menu-class="w-100 text-start"
                                                        >
                                                            <template #button-content>Select Product</template>
                                                            <b-dropdown-form @submit.stop.prevent="() => {}">
                                                                <b-form-group
                                                                    label="Search product"
                                                                    label-for="tag-search-input"
                                                                    label-cols-md="auto"
                                                                    class="mb-0"
                                                                    label-size="sm"
                                                                    :description="searchDesc"
                                                                    :disabled="disabled"
                                                                    placeholder="type your product name"
                                                                >
                                                                    <b-form-input
                                                                        v-model="search"
                                                                        id="tag-search-input"
                                                                        type="search"
                                                                        size="sm"
                                                                        autocomplete="off"
                                                                    ></b-form-input>
                                                                </b-form-group>
                                                            </b-dropdown-form>
                                                            <b-dropdown-item-button
                                                                v-for="(option, index) in sectionTwoAvailableOptions"
                                                                :key="index"
                                                                @click="selectedProduct(option,'section_two_products')"
                                                            >
                                                                <div class="d-flex align-items-center">
                                                                    <img
                                                                        class="mr-2"
                                                                        height="45"
                                                                        :src="option.featured_image"
                                                                        alt
                                                                    />
                                                                    <span>{{ option.name }}</span>
                                                                </div>
                                                            </b-dropdown-item-button>
                                                            <b-dropdown-text v-if="sectionTwoAvailableOptions.length === 0">
                                                                There are no product available to select
                                                            </b-dropdown-text>
                                                        </b-dropdown>
                                                        <ul
                                                            v-if="data.section_two_products.length > 0"
                                                            class="list-inline d-inline-block mb-2 selected-product"
                                                        >
                                                            <li
                                                                v-for="(product, index) in data.section_two_products"
                                                                :key="index"
                                                                class="list-inline-item"
                                                            >
                                                                <b-form-tag
                                                                    @remove="removeSelectedProduct(index,'section_two_products')"
                                                                    :title="product.name"
                                                                    variant="light"
                                                                >
                                                                    <div class="d-flex">
                                                                        <img height="30" :src="product.featured_image" alt />
                                                                        <div class="text-start">
                                                                            <h6 class="m-0">
                                                                                {{ product.name }}
                                                                            </h6>
                                                                            <span class="text-red">
                                                                              BDT{{ product.sale_price }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </b-form-tag>
                                                            </li>
                                                        </ul>
                                                    </template>
                                                </b-form-tags>
                                            </b-form-group>
                                        </div>
                                    </div>
                                    <!-- Section Three-->
                                    <div class="col-sm-12">
                                        <h4># Section Three</h4>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Title *</label>
                                            <input
                                                v-model="data.section_three_title"
                                                type="text"
                                                name="section_three_title"
                                                class="form-control"
                                                placeholder="Enter section title"
                                            >
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label d-block ">Products</label>
                                            <b-form-group
                                                class="w-100 similar-product-selector"
                                                label-for="tags-with-dropdown"
                                            >
                                                <b-form-tags
                                                    id="tags-with-dropdown"
                                                    no-outer-focus
                                                    class="mb-2"
                                                >
                                                    <template v-slot="{ disabled }">
                                                        <b-dropdown
                                                            size="sm"
                                                            variant="outline-light"
                                                            block
                                                            menu-class="w-100 text-start"
                                                        >
                                                            <template #button-content>Select Product</template>
                                                            <b-dropdown-form @submit.stop.prevent="() => {}">
                                                                <b-form-group
                                                                    label="Search product"
                                                                    label-for="tag-search-input"
                                                                    label-cols-md="auto"
                                                                    class="mb-0"
                                                                    label-size="sm"
                                                                    :description="searchDesc"
                                                                    :disabled="disabled"
                                                                    placeholder="type your product name"
                                                                >
                                                                    <b-form-input
                                                                        v-model="search"
                                                                        id="tag-search-input"
                                                                        type="search"
                                                                        size="sm"
                                                                        autocomplete="off"
                                                                    ></b-form-input>
                                                                </b-form-group>
                                                            </b-dropdown-form>
                                                            <b-dropdown-item-button
                                                                v-for="(option, index) in sectionThreeAvailableOptions"
                                                                :key="index"
                                                                @click="selectedProduct(option,'section_three_products')"
                                                            >
                                                                <div class="d-flex align-items-center">
                                                                    <img
                                                                        class="mr-2"
                                                                        height="45"
                                                                        :src="option.featured_image"
                                                                        alt
                                                                    />
                                                                    <span>{{ option.name }}</span>
                                                                </div>
                                                            </b-dropdown-item-button>
                                                            <b-dropdown-text v-if="sectionThreeAvailableOptions.length === 0">
                                                                There are no product available to select
                                                            </b-dropdown-text>
                                                        </b-dropdown>
                                                        <ul
                                                            v-if="data.section_three_products.length > 0"
                                                            class="list-inline d-inline-block mb-2 selected-product"
                                                        >
                                                            <li
                                                                v-for="(product, index) in data.section_three_products"
                                                                :key="index"
                                                                class="list-inline-item"
                                                            >
                                                                <b-form-tag
                                                                    @remove="removeSelectedProduct(index,'section_three_products')"
                                                                    :title="product.name"
                                                                    variant="light"
                                                                >
                                                                    <div class="d-flex">
                                                                        <img height="30" :src="product.featured_image" alt />
                                                                        <div class="text-start">
                                                                            <h6 class="m-0">
                                                                                {{ product.name }}
                                                                            </h6>
                                                                            <span class="text-red">
                                                                              BDT{{ product.sale_price }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </b-form-tag>
                                                            </li>
                                                        </ul>
                                                    </template>
                                                </b-form-tags>
                                            </b-form-group>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 mt-4">
                                        <button v-if="!btnLoader" type="submit"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">Save
                                            Changes
                                        </button>
                                        <button v-else type="button"
                                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="fa fa-spinner fa-spin"></i> Loading..
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end tab content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Homepage",
        data() {
            return {
                btnLoader: false,
                data: {
                    // Top header
                    theme_layout: '',

                    theader_bg_color: '',
                    theader_font_color: '',
                    theader_help_line_number: '',
                    theader_show_help_line: 0,
                    theader_show_language: 0,
                    theader_show_track_order: 0,
                    // Two Column Banner
                    two_column_first_banner: null,
                    two_column_second_banner: null,
                    // Offer Image
                    top_header_banner: null,
                    first_banner: null,
                    popup_banner: null,
                    gif_banner: null,
                    second_banner: null,
                    last_banner: null,
                    // Section One
                    section_one_title:'',
                    section_one_products:[],
                    // Section Two
                    section_two_title:'',
                    section_two_products:[],
                    // Section three
                    section_three_title:'',
                    section_three_products:[]
                },
                image: {
                    top_header_banner: '',
                    first_banner: '',
                    popup_banner: '',
                    gif_banner: '',
                    second_banner: '',
                    last_banner: '',
                    two_column_first_banner:null,
                    two_column_second_banner:null,
                },
                categories:[],
                products:[],
                search: "",
            };
        },
        computed: {
            criteria() {
                return this.search.trim().toLowerCase();
            },
            sectionOneAvailableOptions() {
                const options = this.products.filter(
                    (opt) => this.data.section_one_products.indexOf(opt) === -1
                );
                if (this.criteria) {
                    return options.filter(
                        (product) => product.name.toLowerCase().indexOf(this.criteria) > -1
                    );
                }
                return options;
            },
            sectionTwoAvailableOptions() {
                const options = this.products.filter(
                    (opt) => this.data.section_two_products.indexOf(opt) === -1
                );
                if (this.criteria) {
                    return options.filter(
                        (product) => product.name.toLowerCase().indexOf(this.criteria) > -1
                    );
                }
                return options;
            },
            sectionThreeAvailableOptions() {
                const options = this.products.filter(
                    (opt) => this.data.section_three_products.indexOf(opt) === -1
                );
                if (this.criteria) {
                    return options.filter(
                        (product) => product.name.toLowerCase().indexOf(this.criteria) > -1
                    );
                }
                return options;
            },
            searchDesc() {
                if (this.criteria) {
                    return "There are no product matching your search criteria";
                }
                return "";
            },
        },
        methods: {
            selectedProduct(product,productSection) {
                this.data[productSection].push(product);
                this.search = "";
            },
            removeSelectedProduct(product,productSection) {
                this.data[productSection].splice(product, 1);
            },
            saveThemeLayout(){
                let form = document.getElementById('saveThemeLayout');
                let formData = new FormData(form);
                this.saveSetting('setting/homepage/theme-layout', formData);
            },
            saveSetting(url, data) {
                this.btnLoader = true;
                axios.post(url, data).then(res => {
                    this.notification(res.data.message, "success");
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    setTimeout(() => {
                        this.btnLoader = false
                    }, 1000)
                });
            },
            saveTopHeader() {
                this.saveSetting('setting/homepage/store', this.data);
            },
            saveOfferBanner() {
                let form = document.getElementById('offer-banner-form');
                let formData = new FormData(form);
                this.saveSetting('setting/homepage/offer-banner', formData);
            },
            savePopupBanner() {
                let form = document.getElementById('popup-banner-form');
                let formData = new FormData(form);
                this.saveSetting('setting/homepage/popup-banner', formData);
            },
            savePopularProduct() {
                this.saveSetting('setting/homepage/popular-category', this.data);
            },
            saveTwoColumnBanner() {
                let form = document.getElementById('two-column-banner-form');
                let formData = new FormData(form);
                this.saveSetting('setting/homepage/two-column-banner', formData);
            },
            saveSectionProduct() {
                this.saveSetting('setting/homepage/section-product', this.data);
            },
            getHomepageSettings() {
                axios.get('setting/homepage').then(res => {
                    this.data = res.data;
                })
            },
            imageHandler(e,imagePath,fieldClass){
                this.showImage(e, imagePath, imagePath,  fieldClass, null);
            },
            removeImage(image){
                this.data[image] = null
                this.image[image] = null
            }
        },
        created() {
            this.getHomepageSettings();
            this.setBreadcrumbs("Homepage", "index", "Homepage Setting");
            axios.get('categories').then(res => this.categories = res.data);
            axios.get('product-list').then(res => this.products = res.data);
        },
    };
</script>

<style lang="scss">
    li.list-inline-item {
        background: #ffffff;
        margin: 4px;
        width: 150px;
        box-shadow: 0 0px 2px #4444;
        span.badge.b-form-tag {
            color: #6a6262;
            justify-content: space-around;
            align-items: center;
            font-size: 12px;
        }
        img.tag-image {
            height: 20px;
            width: 20px;
            border-radius: 5px;
        }
        button.close.b-form-tag-remove {
            padding: 2px 4px;
            border: 0;
            background: red;
            color: #fff;
            display: block;
            border-radius: 3px;
        }
    }
    .similar-product-selector {
        div#tags-with-dropdown {
            padding: 0;
            border: 0;
        }
        button.btn-outline-light {
            text-align: left;
            display: block;
            width: 100%;
            padding: 0.5rem 0.9rem;
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--vz-body-color);
            background-color: var(--vz-input-bg);
            background-clip: padding-box;
            border: 1px solid var(--vz-input-border);
        }
        ul.dropdown-menu {
            box-shadow: 0px 4px 6px #4444;
            padding: 10px;
            border: 1px solid #3f51b5 !important;
            max-height: 298px !important;
            overflow-y: auto;
            transform: translate3d(0px, 38px, 0px)!important;
        }
        ul.selected-product {
            margin-top: 5px;
            margin-bottom: 0 !important;
            li {
                padding: 4px;
            }
        }
        button.close.b-form-tag-remove {
            color: #fff !important;
        }
        button.dropdown-item {
            color: #000 !important;
            white-space: normal;
        }
    }
    span.step-title i {
        font-size: 20px;
    }
</style>
