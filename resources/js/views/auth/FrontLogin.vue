<template>
    <main class="form-signin">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <img :src="$root.baseurl+'/frontend/images/front-login-img.jpg'"  alt="Login Image" width="100%" height="100%">
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p class="text-muted">Sign in to continue to {{ $root.global.app_name }}</p>
                                        </div>

                                        <div class="mt-4">
                                            <form v-on:submit.prevent="submit" class="mt-4">
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.email'),
                                                    'has-success': data.email,
                                                  }">
                                                    <label for="username" class="form-label">Email</label>
                                                    <input type="text" v-model="data.email" class="form-control"
                                                           id="username" placeholder="Enter Email">
                                                    <span class="help-block text-danger">
                                                      {{ validation.firstError("data.email") }}
                                                  </span>
                                                </div>

                                                <div class="mb-3" :class="{
                                                        'has-error': validation.hasError('data.password'),
                                                        'has-success': data.password,
                                                      }">
                                                    <div class="float-end">
                                                        <router-link :to="{name:'forgetpassword'}" class="text-muted">Forgot
                                                            password?
                                                        </router-link>
                                                    </div>
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input v-model="data.password" :type="passwordText"
                                                               class="form-control pe-5 password-input"
                                                               placeholder="Enter password" id="password-input">
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            type="button" @click="passwordType(passwordText)" id="password-addon"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                    <span class="help-block text-danger">
                                                      {{ validation.firstError("data.password") }}
                                                  </span>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="data.remember"
                                                           type="checkbox" value="" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">Remember
                                                        me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button v-if="!btnLoader" class="btn btn-primary w-100" type="submit">Sign In</button>
                                                    <button v-else disabled class="btn btn-primary w-100" type="button">
                                                      <i class="mdi mdi-sync mdi-spin fs-16"></i>  Sign In
                                                    </button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                                    </div>

                                                    <div>
                                                        <a v-if="$root.global.facebook_login" :href="$root.baseurl+'/login/facebook'"
                                                                class="btn btn-primary btn-icon waves-effect waves-light">
                                                            <i class="ri-facebook-fill fs-16"></i>
                                                        </a>
                                                        <a v-if="$root.global.google_login" :href="$root.baseurl+'/login/google'"
                                                                class="btn btn-danger btn-icon waves-effect waves-light">
                                                            <i class="ri-google-fill fs-16"></i>
                                                        </a>
                                                        <a v-if="$root.global.twitter_login" :href="$root.baseurl+'/login/twitter'"
                                                                class="btn btn-info btn-icon waves-effect waves-light">
                                                            <i class="ri-twitter-fill fs-16"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Don't have an account ?
                                                <router-link :to="{name:'register'}" class="fw-semibold text-primary text-decoration-underline">
                                                Signup</router-link>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
    </main>
</template>


<script>
    export default {
        data() {
            return {
                btnLoader:false,
                passwordText: "password",

                data: {
                    email: "",
                    password: "",
                    remember: false,
                },
            };
        },

        methods: {
            submit() {
                const error = this.validation.countErrors();
                this.$validate().then((res) => {
                    if (res) {
                        this.btnLoader = true;
                        axios
                            .post("/login", this.data)
                            .then((res) => {
                                if (res.status == 200 && res.data.id) {
                                    User.login(res.data);
                                    this.notification(res.data.message, "success");
                                    window.location = this.$root.baseurl + "/user/dashboard";
                                } else {
                                    this.btnLoader = false;
                                    this.notification(res.data.message, "error");
                                }
                            })
                            .catch((error) => {
                                this.btnLoader = false;
                                this.notification(
                                    "Something went wrong, please try again",
                                    "error"
                                );
                            });
                    }
                });
            },
            passwordType(passwordText) {
                if (passwordText == "password") {
                    this.passwordText = "text";
                } else {
                    this.passwordText = "password";
                }
            },
        },

        // ================== validation rule for form ==================
        validators: {
            "data.email": function (value = null) {
                return Validator.value(value).required("Email is required");
            },
            "data.password": function (value = null) {
                return Validator.value(value)
                    .required("Password is required");
            },
        },
    };
</script>
<style scoped>
    .form-signin img{
        object-fit: cover !important;
    }
</style>
