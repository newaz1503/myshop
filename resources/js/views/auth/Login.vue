<template>
    <section class="loginpage">
        <div class="container">
            <div class="row justify-content-center align-content-center">
                <div class="col-lg-10">
                    <div class="card card-body p-5 rounded-5">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-lg-5">
                                <div class="mt-2">
                                    <h5 class="text-primary"><span
                                        class="welcome">Welcome to the Login</span></h5>
                                    <p class="text-muted">Please Log in to continue to Admin
                                        Dashboard</p>
                                </div>
                                <form v-on:submit.prevent="submit" method="post" class="login">
                                    <div class="mt-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Your Email</label>
                                            <input
                                                class="form-control"
                                                type="email" id="emailaddress"
                                                v-model="data.email"
                                                placeholder="User name / Email"
                                            />
                                        </div>
                                        <div class="text-danger">
                                            {{ validation.firstError("data.email") }}
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Your Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input
                                                    :type="passwordText"
                                                    v-model="data.password"
                                                    id="password"
                                                    class="form-control"
                                                    placeholder="Enter your password"
                                                >
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" @click="passwordType(passwordText)"
                                                    id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div class="text-danger">
                                            {{ validation.firstError("data.password") }}
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="checkbox-signin" checked="">
                                            <label class="form-check-label" for="checkbox-signin">Remember
                                                me</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-0 text-center">
                                        <button v-if="!$root.spinner" class="btn btn-primary w-100"
                                                type="submit"> Log In
                                        </button>
                                        <button v-else class="btn btn-primary w-100" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm me-1"
                                                              role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>
                                    </div>

                                </form>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-5">
                                <img :src="$root.baseurl+'/public/frontend/images/admin-login.jpg'"
                                     class="img-fluid rounded login_img" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                //   passwordIstext: false,
                passwordText: "password",
                link: '',
                data: {
                    email: "dev.tusharahmed@gmail.com",
                    password: "123456",
                },
            };
        },
        methods: {
            passwordType(passwordText) {
                if (passwordText == "password") {
                    this.passwordText = "text";
                } else {
                    this.passwordText = "password";
                }
            },
            submit() {
                const error = this.validation.countErrors();
                this.$validate().then((res) => {
                    if (res) {
                        this.$root.spinner = true;
                        axios
                            .post("/admin/login-admin", this.data)
                            .then((res) => {
                                if (res.status == 200 && res.data.id) {
                                    Admin.login(res.data);
                                    this.notification(res.data.message, "success");
                                    window.location = this.$root.baseurl + "/admin/dashboard";
                                } else {
                                    this.$root.spinner = false;
                                    this.notification(res.data.message, "error");
                                }
                            })
                            .catch((error) => {
                                this.$root.spinner = false;
                                this.notification(
                                    "Something went wrong, please try again",
                                    "error"
                                );
                            });
                    }
                });
            },
        },

        // ================== validation rule for form ==================
        validators: {
            "data.email": function (value = null) {
                return Validator.value(value).required("Email is required");
            },
            "data.password": function (value = null) {
                return Validator.value(value)
                    .required("Password is required")
                    .minLength(6);
            },
        },
    };
</script>
<style lang="scss" scoped>
    html {
        overflow: hidden;
        height: 100%;
    }

    .loginpage {
        background: linear-gradient(30deg, #3f51b5 0%, #3f51b5 4%, #eff1ff 59%, #ffffffc9 95%);
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        .card.card-body {
            backdrop-filter: blur(14px);
            background: #ffffffad;
        }
    }

    .btn {
        background: #405189;
    }

    .btn:hover {
        background: #ff6231;
    }

    .welcome {
        color: #405189;
    }

    .login_img {
        width: 100%;
        height: auto;
    }

    @media (max-width: 991px) {
        .login_img {
            display: none;
        }
        .card {
            margin-top: 20px;
        }
    }

    @media (max-width: 600px) {
        .loginpage {
            padding: 8px 0 !important;
        }
    }

</style>
