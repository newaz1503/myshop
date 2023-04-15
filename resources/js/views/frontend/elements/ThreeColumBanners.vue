<template>
    <section id="3_colum_banner" class="mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-4" v-if="$root.global.two_column_second_banner">
                    <a href="">
                        <img :src="$root.global.two_column_second_banner" class="img-fluid" alt="">
                    </a>
                </div>
                <div class="col-lg-4" v-if="$root.global.two_column_first_banner">
                    <a href="">
                        <img :src="$root.global.two_column_first_banner" class="img-fluid" alt="">
                    </a>
                </div>
                <div class="col-lg-4" v-if="$root.global.two_column_second_banner">
                    <a href="">
                        <img :src="$root.global.two_column_second_banner" class="img-fluid" alt="">
                    </a>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "ThreeColumBanners"
    }
</script>

<style scoped>

</style>
