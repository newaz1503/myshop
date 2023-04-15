<template>
    <div class="">
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <form @submit.prevent="googleForm" id="googleForm">
                    <div class="card ribbon-box right overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="w-50 m-auto form-check form-switch form-switch-lg" dir="ltr">
                                            <input type="checkbox" name="google_login" v-model="data.google_login" class="form-check-input"
                                                   id="googleActivation">
                                            <label class="form-check-label" for="googleActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Google Login Credential</span>
                                </h5>
                            </div>

                            <div class="row mt-4">
                                <div class="mb-2">
                                    <label class="col-from-label">Client Id</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="GOOGLE_CLIENT_ID"
                                        placeholder="Google Client Id"
                                        v-model="data.GOOGLE_CLIENT_ID"
                                    >
                                </div>
                                <div class="mb-2">
                                    <label class="col-from-label">Client Secret</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="GOOGLE_CLIENT_SECRET"
                                        placeholder="Google Client Secret"
                                        v-model="data.GOOGLE_CLIENT_SECRET"
                                    >
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-4 col-lg-6">
                <form @submit.prevent="facebookForm" id="facebookForm">
                    <div class="card ribbon-box right overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="w-50 m-auto form-check form-switch form-switch-lg" dir="ltr">
                                            <input type="checkbox" v-model="data.facebook_login" name="facebook_login" class="form-check-input"
                                                   id="facebookActivation">
                                            <label class="form-check-label" for="facebookActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Facebook Login Credential</span>
                                </h5>
                            </div>

                            <div class="row mt-4">
                                <div class="mb-2">
                                    <label class="col-from-label">App ID</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="FACEBOOK_CLIENT_ID"
                                        placeholder="Facebook Client Id"
                                        v-model="data.FACEBOOK_CLIENT_ID"
                                    >
                                </div>
                                <div class="mb-2">
                                    <label class="col-from-label">App Secret</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="FACEBOOK_CLIENT_SECRET"
                                        placeholder="Facebook Client Secret"
                                        v-model="data.FACEBOOK_CLIENT_SECRET"
                                    >
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-4 col-lg-6">
                <form @submit.prevent="twitterForm" id="twitterForm">
                    <div class="card ribbon-box right overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="w-50 m-auto form-check form-switch form-switch-lg" dir="ltr">
                                            <input type="checkbox" v-model="data.twitter_login" name="twitter_login" class="form-check-input"
                                                   id="twitterActivation">
                                            <label class="form-check-label" for="twitterActivation">Activation</label>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 mt-4">
                                    <span class="link-primary">Twitter Login Credential</span>
                                </h5>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label class="col-from-label">App Key</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="TWITTER_CLIENT_ID"
                                        placeholder="Twitter App Key"
                                        v-model="data.TWITTER_CLIENT_ID"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="col-from-label">App Secret</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="TWITTER_CLIENT_SECRET"
                                        placeholder="Twitter App Secret"
                                        v-model="data.TWITTER_CLIENT_SECRET"
                                    >
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-border btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SocialLogin",
        data() {
            return {
                data: {
                    google_login:0,
                    GOOGLE_CLIENT_ID:'',
                    GOOGLE_CLIENT_SECRET:'',

                    facebook_login:0,
                    FACEBOOK_CLIENT_ID:0,
                    FACEBOOK_CLIENT_SECRET:'',

                    twitter_login:0,
                    TWITTER_CLIENT_ID:'',
                    TWITTER_CLIENT_SECRET:'',
                }
            }
        },

        methods:{
            submitHandler(url,data){
                this.$root.validation_errors = {};
                this.$root.submit = true;
                this.$root.spinner = true;
                axios.post(url, data).then(res => {
                    if (res.data.message) {
                        this.notification(res.data.message, "success");
                    } else if (res.data.error) {
                        this.notification(res.data.error, "error");
                    } else if (res.data.warning) {
                        this.notification(res.data.warning, "warning");
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.$bvModal.show("validate-error");
                        if (error.response.data.exception) {
                            this.$root.exception_errors = error.response.data.exception
                        } else {
                            this.$root.validation_errors = error.response.data.errors || {};
                        }

                        this.notification("You need to fill empty mandatory fields", "warning");
                    }
                }).finally(() => this.$root.spinner = false);
            },
            googleForm(){
                let form  = document.getElementById('googleForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/social/google',formData);
            },
            facebookForm(){
                let form  = document.getElementById('facebookForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/social/facebook',formData);
            },
            twitterForm(){
                let form  = document.getElementById('twitterForm');
                let formData  =  new FormData(form);
                this.submitHandler('setting/social/twitter',formData);
            },
        },
        created() {
            this.setBreadcrumbs("Setting", "edit", "Social Login");
            axios.get('setting/social-login').then(res => {
                this.data =  res.data;
            }).catch(error => {
                console.log(error)
            })
        }
    }
</script>

<style scoped>

</style>
