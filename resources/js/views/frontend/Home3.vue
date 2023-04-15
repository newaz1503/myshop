<template>
    <div>
        <!-- Categories, Slider, Banner -->
        <HeroSection3></HeroSection3>
        <!-- 2 Colum banner part start -->
        <!-- Campaign -->
        <Campaign></Campaign>
        <!-- Category pages part start -->
        <TopCategories></TopCategories>
        <!-- Hot Product part start -->
        <SectionProduct :products="sectionOneProudct" :sectionTitle="sectionOneTitle"></SectionProduct>
        <!-- 2 Colum banner part start -->
        <TwoColumBanners></TwoColumBanners>

        <SectionProduct :products="sectionTwoProudct" :sectionTitle="sectionTwoTitle"></SectionProduct>
        <!-- Category Product part start -->
        <CategoryWiseProduct></CategoryWiseProduct>
        <!-- brand pages part start -->
        <Brands></Brands>
        <!-- Today deal Product part start -->
        <LastSection :products="sectionThreeProudct" :sectionTitle="sectionThreeTitle"></LastSection>
        <!-- service part start -->
        <Services></Services>
    </div>
</template>

<script>
    import HeroSection3 from "./elements/HeroSection3";
    import Services from "./elements/Services";
    import TopCategories from "./elements/TopCategories";
    import HotProduct from "./elements/HotProduct";
    import LatestProduct from "./elements/LatestProduct";
    import Brands from "./elements/Brands";
    import TwoColumBanners from "./elements/TwoColumBanners";
    import ThreeColumBanners from "./elements/ThreeColumBanners";
    import SectionProduct from "./elements/SectionProduct";
    import CategoryWiseProduct from "./elements/CategoryWiseProduct";
    import LastSection from "./elements/LastSection";
    import Campaign from "./elements/Campaign";


    export default {
        components: {
            Campaign,
            LastSection,
            CategoryWiseProduct,
            SectionProduct,
            TwoColumBanners,
            ThreeColumBanners,
            Brands,
            LatestProduct,
            HotProduct,
            TopCategories,
            Services,
            HeroSection3
        },
        data() {
            return {
                datas: {data: {}},
                sectionOneTitle:'',
                sectionOneProudct:[],

                sectionTwoTitle:'',
                sectionTwoProudct:[],

                sectionThreeTitle:'',
                sectionThreeProudct:[],
            };
        },
        mounted: function () {
            this.get_data("get-home-page", "data");
        },
       async created() {
            await axios.get('get-sectionOne').then(res => {
                this.sectionOneTitle = res.data.section_one_title;
                this.sectionOneProudct = res.data.section_one_products;
            });
           await axios.get('get-sectionTwo').then(res => {
               this.sectionTwoTitle = res.data.section_two_title;
               this.sectionTwoProudct = res.data.section_two_products;
           });
           await axios.get('get-sectionThree').then(res => {
               this.sectionThreeTitle   = res.data.section_three_title;
               this.sectionThreeProudct = res.data.section_three_products;
           });
        }
    };
</script>
