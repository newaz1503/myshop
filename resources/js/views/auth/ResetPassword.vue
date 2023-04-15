<template>
    <main class="form-signin">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <img :src="$root.baseurl+'/frontend/images/front-login-img.jpg'" alt="Login Image"
                                         width="100%" height="100%">
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Reset Your Password</h5>
                                        </div>

                                        <div class="mt-4">
                                            <form v-on:submit.prevent="resetPassword" class="mt-4">
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.password'),
                                                    'has-success': data.password,
                                                  }">
                                                    <label for="username" class="form-label">New Password</label>
                                                    <input type="text" v-model="data.password" class="form-control"
                                                           placeholder="New Password">
                                                    <span class="help-block text-danger">
                                                      {{ validation.firstError("data.password") }}
                                                  </span>
                                                </div>
                                                <div class="mb-3" :class="{
                                                    'has-error': validation.hasError('data.password_confirmation'),
                                                    'has-success': data.password_confirmation,
                                                  }">
                                                    <label for="username" class="form-label">Confirm Password</label>
                                                    <input type="text" v-model="data.password_confirmation"
                                                           class="form-control"
                                                           placeholder="Confirm Password">
                                                    <span class="help-block text-danger">
                                                      {{ validation.firstError("data.password_confirmation") }}
                                                  </span>
                                                </div>
                                                <div class="mt-4">
                                                    <button v-if="!btnLoader" class="btn btn-primary w-100"
                                                            type="submit">Reset Password
                                                    </button>
                                                    <button v-else disabled class="btn btn-primary w-100" type="button">
                                                        <i class="mdi mdi-sync mdi-spin fs-16"></i> Reset Password
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Don't want to reset password?
                                                <router-link :to="{name:'login'}"
                                                             class="fw-semibold text-primary text-decoration-underline">
                                                    Back to Login
                                                </router-link>
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
                btnLoader: false,
                passwordText: "password",

                data: {
                    email: "",
                    token: "",
                    password: "",
                    password_confirmation: "",
                },
            };
        },

        methods: {
            resetPassword() {
                const error = this.validation.countErrors();
                this.$validate().then((res) => {
                    if (res) {
                        this.btnLoader = true;
                        axios
                            .post("/reset-password", this.data)
                            .then((res) => {
                                if (res.status == 200) {
                                    this.notification(res.data.message, "success");
                                    setTimeout(() => {
                                        this.$router.push({ name: "login" });
                                    }, 200);
                                } else {
                                    this.btnLoader = false;
                                    this.notification(res.data.message, "error");
                                }
                            })
                            .catch((error) => {
                                this.btnLoader = false;
                                this.notification(error.response.data.error, "error");
                            }).finally(() => {
                            this.btnLoader = false;
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
        created() {
            axios.get('reset-password/' + this.$route.params.slug).then(res => {
                this.data.email = res.data.email;
                this.data.token = res.data.token;
            }).catch(err => {
                console.log(err);
            })
        },

        // ================== validation rule for form ==================
        validators: {
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
    .form-signin img {
        object-fit: cover !important;
    }
</style>
