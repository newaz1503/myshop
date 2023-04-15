<template>
    <main class="form-signup">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="card overflow-hidden m-0">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <img :src="$root.baseurl+'/frontend/images/front-login-img.jpg'" alt="Login Image"
                                         width="100%" height="100%">
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Create an Account</h5>
                                            <p class="text-muted">Get your {{ $root.global.app_name }} account now.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="needs-validation" v-on:submit.prevent="submit">
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.name'),
                                                    'has-success': data.name,
                                                  }">
                                                    <label for="name" class="form-label">Full Name <span
                                                        class="text-danger">*</span></label>
                                                    <input type="text" v-model="data.name" class="form-control"
                                                           id="name" placeholder="Enter Full Name">
                                                    <div class="text-danger">
                                                        {{ validation.firstError("data.name") }}
                                                    </div>
                                                </div>
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.phone'),
                                                    'has-success': data.phone,
                                                  }">
                                                    <label for="phone" class="form-label">Phone <span
                                                        class="text-danger">*</span></label>
                                                    <input type="text" v-model="data.phone" class="form-control"
                                                           id="phone" placeholder="Enter Phone">
                                                    <div class="text-danger">
                                                        {{ validation.firstError("data.phone") }}
                                                    </div>
                                                </div>
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.email'),
                                                    'has-success': data.email,
                                                  }">
                                                    <label for="useremail" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                    <input type="email" v-model="data.email" class="form-control"
                                                           id="useremail" placeholder="Enter email address">
                                                    <div class="text-danger">
                                                        {{ validation.firstError("data.email") }}
                                                    </div>
                                                </div>
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.password'),
                                                    'has-success': data.password,
                                                  }">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input :type="passwordText" v-model="data.password"
                                                               class="form-control pe-5 password-input"
                                                               onpaste="return false" placeholder="Enter password"
                                                               id="password-input">
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            type="button" @click="passwordType(passwordText)"
                                                            id="password-addon"><i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                        <div class="text-danger">
                                                            {{ validation.firstError("data.password") }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.password_confirmation'),
                                                    'has-success': data.password_confirmation,
                                                  }">
                                                    <label class="form-label" for="password-input">Confirm
                                                        Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input :type="passwordText" v-model="data.password_confirmation"
                                                               class="form-control pe-5 password-input"
                                                               onpaste="return false" placeholder="Enter password"
                                                               id="confirm-password">
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            @click="passwordType(passwordText)" type="button"
                                                            id="password-addon"><i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                        <div class="text-danger">
                                                            {{ validation.firstError("data.password_confirmation") }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree
                                                        to the {{ $root.global.app_name }}
                                                        <router-link :to="{name:'content.page',params:{slug:'terms-conditions'}}" class="text-primary text-decoration-underline fst-normal fw-medium">
                                                            Terms of Use
                                                        </router-link>
                                                    </p>
                                                </div>
                                                <div class="mt-4">
                                                    <button v-if="!btnLoader" class="btn btn-primary w-100"
                                                            type="submit">Sign Up
                                                    </button>
                                                    <button v-else disabled class="btn btn-primary w-100" type="button">
                                                        <i class="mdi mdi-sync mdi-spin fs-16"></i> Sign Up
                                                    </button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                                    </div>

                                                    <div>

                                                        <a v-if="$root.global.facebook_login"
                                                           :href="$root.baseurl+'/login/facebook'"
                                                           class="btn btn-primary btn-icon waves-effect waves-light">
                                                            <i class="ri-facebook-fill fs-16"></i>
                                                        </a>
                                                        <a v-if="$root.global.google_login"
                                                           :href="$root.baseurl+'/login/google'"
                                                           class="btn btn-danger btn-icon waves-effect waves-light">
                                                            <i class="ri-google-fill fs-16"></i>
                                                        </a>
                                                        <a v-if="$root.global.twitter_login"
                                                           :href="$root.baseurl+'/login/twitter'"
                                                           class="btn btn-info btn-icon waves-effect waves-light">
                                                            <i class="ri-twitter-fill fs-16"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Already have an account ?
                                                <router-link :to="{name:'login'}"
                                                             class="fw-semibold text-primary text-decoration-underline">
                                                    Signin
                                                </router-link>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                btnLoader: false,

                data: {
                    name: "",
                    phone: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    remember: false,
                    user_type: 'online',

                },
                passwordText: "password",
            };
        },
        methods: {
            submit() {
                const error = this.validation.countErrors();
                this.$validate().then((res) => {
                    if (res) {
                        this.btnLoader = true;
                        axios
                            .post("/register", this.data)
                            .then((res) => {
                                if (res.status == 200) {
                                    this.notification(res.data.message, "success");
                                    this.$router.push({name: 'login'})
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
                                if (error.response.data.errors.email){
                                    this.notification(error.response.data.errors.email[0],"error");
                                }
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
            "data.name": function (value = null) {
                return Validator.value(value).required("Name is required");
            },
            "data.phone": function (value = null) {
                return Validator.value(value)
                    .required("Phone is required")
                // .regex("01+[0-9+-]*$", "Must start with 01.")
            },
            "data.email": function (value = null) {
                return Validator.value(value).required("Email is required");
            },
            "data.password": function (value = null) {
                return Validator.value(value).required("Password is required").minLength(6);
            },
            "data.password_confirmation, data.password": function (password_confirmation = null, password = null) {
                return Validator.value(password_confirmation)
                    .required("Password confirmation is required")
                    .match(password);
            },
        },
    };
</script>
<style scoped>
    .form-signup img {
        object-fit: cover !important;
    }
</style>
