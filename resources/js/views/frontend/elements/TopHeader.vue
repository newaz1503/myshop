<template>
    <header id="top_header" class="border-bottom top-header-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-6">
                    <ul class=" d-flex align-items-center p-xs-0 p-sm-0">
                        <li class="border-start px-3 d-xs-none d-sm-none d-xxl-block d-xl-block d-lg-block d-md-block d-xs-none">
                            <a href="javascript:" v-if="$root.global && $root.global.theader_show_help_line" class="top-header-color text-truncate">
                                <i class=" ri-phone-line"></i>
                                <span class="d-sm-none">
                                    Help Line :
                                </span>
                                <a class="top-header-color" :href="`tel::${$root.global.theader_help_line_number}`">
                                    {{ $root.global.theader_help_line_number }}
                                </a>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-6 d-flex align-items-center justify-content-end custom_font_weight">
                    <ul class="d-flex align-items-center p-0">
                        <li class="border-start px-3 d-xl-none d-xxl-none d-lg-none d-sm-block d-md-none d-xs-blck p-sm-0 p-xs-0">
                            <a :href="`tel::${$root.global.theader_help_line_number}`" v-if="$root.global && $root.global.theader_show_help_line" class="top-header-color text-truncate">
                                <i class=" ri-phone-line"></i>
                                <span class="d-sm-none">  Help Line : </span> {{ $root.global && $root.global.theader_help_line_number }}
                            </a>
                        </li>
                        <li class="list-unstyled  border-start px-3" v-if="$root.global && $root.global.theader_show_track_order">
                            <router-link :to="{name:'user.trackorder'}" class="top-header-color text-truncate">
                                <i class="mdi mdi-truck-fast-outline"></i>
                                Track Order
                            </router-link>
                        </li>
                        <li class="border-start px-3 header_item_none d-xs-none d-sm-none d-md-block d-lg-block">
                            <router-link :to="{name:'user.wisthlist'}" class="top-header-color text-truncate">
                                <i class=" bx bx-heart"></i>
                                Wish List</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
    export default {
        name: "TopHeader"
    }
</script>

<style scoped>

</style>
