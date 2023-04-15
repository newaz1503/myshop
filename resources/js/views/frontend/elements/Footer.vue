<template>
    <div class="footer-section">
        <section id="footer-top" class="bg-dark">
            <div class="container">
                <div class="row text-white">
                    <div class="col-lg-3">
                        <div class="custom_footer_box">
                            <img v-if="footerData" :src="footerData.white_logo" class="img-fluid mb-4" alt="white logo.png">
                        </div>
                        <p class="text-white" v-if="footerData.site_description">{{footerData.site_description  }}</p>
                        <div class="mt-2">
                        <ul class="d-flex align-items-center justify-content-start" v-if="footerData.social_links && Object.keys(footerData.social_links).length > 0">
                            <li v-for="social in JSON.parse(footerData.social_links)" :key="social.id" class="social_icon">
                                <a :href="social.url" target="_blank">
                                    <i :class="social.icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
                    <div class="col-lg-3">
                        <h4 v-if="footerData">{{ footerData.footer_section_one_title }}</h4>
                            <ul v-if="footerData.footer_section_one_links">
                                <li v-for="item1 in footerData.footer_section_one_links" :key="item1.id">
                                    <a :href="item1.url">
                                        <i class="bx bx-chevrons-right"></i>
                                        {{ item1.label }}</a>
                                </li>
                            </ul>
                    </div>
                    <div class="col-lg-3">
                        <h4 v-if="footerData">{{ footerData.footer_section_two_title }}</h4>
                            <ul v-if="footerData.footer_section_two_links && Object.keys(footerData.footer_section_two_links).length > 0">
                                <li v-for="item2 in footerData.footer_section_two_links" :key="item2.id">
                                    <a :href="item2.url" v-if="item2.label">
                                        <i class="bx bx-chevrons-right"></i>
                                        {{ item2.label}}
                                    </a>
                                </li>
                            </ul>
                    </div>
                    <div class="col-lg-3 contact_info">
                        <h4>Contact Information</h4>
                            <ul>
                                <li>
                                    <a href="mailto:connect@ayantec.com" v-if="footerData.store_email">
                                        <strong>Email :
                                        </strong>
                                        <span>{{footerData.store_email  }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a :href="`tell:${footerData.store_phone}`" v-if="footerData.store_phone">
                                        <strong>Phone :
                                        </strong>
                                        <span>{{footerData.store_phone  }} </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" v-if="footerData.store_address">
                                        <address>
                                            <strong>Address :
                                            </strong>
                                            {{footerData.store_address  }}
                                        </address>
                                    </a>
                                </li>
                            </ul>
                            <form @submit.prevent="sendSubscriberMail" v-if="footerData.show_newsletter">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" v-model="data.email"  placeholder="Enter Your Email">
                                    <button type="submit" class="btn btn-outline-success text-white border-white" >Subscribe</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <ul class="d-flex gap-3 justify-content-center">
                    <li><router-link :to="{name:'content.page',params:{slug:'terms-conditions'}}">Terms & Conditions</router-link> </li>
                    <li><router-link :to="{name:'content.page',params:{slug:'return-policy'}}">Return Policy</router-link> </li>
                    <li><router-link :to="{name:'content.page',params:{slug:'warranty-policy'}}">Warranty Policy</router-link> </li>
                    <li><router-link :to="{name:'content.page',params:{slug:'privacy-policy'}}">Privacy Policy</router-link> </li>
                </ul>
            </div>
            <div class="container text-center mt-1">
                <img :src="footerData.getway_image" height="40px" alt="">
            </div>
        </section>
        <footer>
            <div class="container">
                <div class="row">
                    <p class="text-center text-white">©{{ new Date().getFullYear() }} | {{ $root.global.app_name }}</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        name: "Footer",
        data(){
            return{
                footerData: {},
                 btnLoader: false,
                data: {
                    email: '',
                },
            }
        },
        mounted(){
            this.getFooterData()
        },
        methods:{
             sendSubscriberMail() {
                this.$validate().then((res) => {
                    const error = this.validation.countErrors();
                    // If there is an error
                    if (error > 0) {
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "warning"
                        );
                        return false;
                    }
                    if (res) {
                        this.btnLoader = true;
                        axios.post('/subscriber-store', this.data).then(res => {
                            this.notification('Thank you for subcription!', "success");
                            this.data.email = "";
                        }).catch(error => {
                            console.log(error);
                            if (error.response.data.errors.email){
                                this.notification(error.response.data.errors.email[0],"error");
                            }
                        })

                    }
                });
            },
            getFooterData(){
                axios.get('/global-footer')
                .then(response => {
                    this.footerData = response.data
                })
                .catch(e => {
                    console.log(e);
                })
            }
        },
         validators: {
            "data.email": function (value = null) {
                return Validator.value(value).required("Email is required");
            },

        },
    }
</script>

<style scoped>
    .social_icon{
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #fff;
        margin-right: 8px;
    }
    .custom_footer_subs_btn{
        margin-top: 27px;
    }

</style>
