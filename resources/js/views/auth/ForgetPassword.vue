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
                                            <h5 class="text-primary">Reset Your Password</h5>
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
                                                <div class="mt-4">
                                                    <button v-if="!btnLoader" class="btn btn-primary w-100" type="submit">Send Password Reset Link</button>
                                                    <button v-else disabled class="btn btn-primary w-100" type="button">
                                                      <i class="mdi mdi-sync mdi-spin fs-16"></i> Send Password Reset Link
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Don't want to reset password?
                                                <router-link :to="{name:'login'}" class="fw-semibold text-primary text-decoration-underline">
                                                Back to Login</router-link>
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
                            .post("/forget-password", this.data)
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
        },
    };
</script>
<style scoped>
    .form-signin img{
        object-fit: cover !important;
    }
</style>
