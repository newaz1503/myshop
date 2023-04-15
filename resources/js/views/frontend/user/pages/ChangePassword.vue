<template>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Your Password</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="userPasswordChange">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <Input
                                title="Old Password"
                                type="password"
                                field="old_password"
                                :red="true"
                                col="12">
                            </Input>
                            <Input
                                title="New Password"
                                type="password"
                                field="new_password"
                                :red="true"
                                col="12">
                            </Input>
                            <Input
                                title="Confirm Password"
                                type="password"
                                field="confirm_password"
                                :red="true"
                                col="12">
                            </Input>
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn bg-color text-white">Change
                                        Password
                                    </button>
                                </div>
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
        name: "ChangePassword",
        data() {
            return {
                data: {
                    old_password: '',
                    new_password: '',
                    confirm_password: ''

                }
            };
        },
        methods: {
            userPasswordChange() {
                const error = this.validation.countErrors();
                this.$validate().then((res) => {
                    // If there is an error
                    if (error > 0) {
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "warning"
                        );
                        return false;
                    }
                    // If there is no error
                    if (res) {
                        axios.post('user/changepassword', this.data).then((response) => {
                            if (response) {
                                if (response.data.success == false) {
                                    this.notification("Credentials did not match !!!", "error");
                                }
                                if (response.data.success == true) {
                                    this.notification("Password Updated Successfully !!!", "success");
                                    User.logout();
                                }
                            }
                        }).catch((error) => {
                            console.log(error)
                        })
                    }
                });
            }
        },


        // ================== validation rule for form ==================
        validators: {
            "data.old_password": function (value = null) {
                return Validator.value(value).required("Old password is required")
            },
            "data.new_password": function (value = null) {
                return Validator.value(value).required("New password is required")
                    .minLength(6);
            },
            "data.confirm_password, data.new_password": function (
                confirm_password = null,
                new_password = null
            ) {
                return Validator.value(confirm_password)
                    .required("Password confirmation is required")
                    .match(new_password);
            },
        },
    };
</script>
<style scoped>
    .form-group {
        margin-bottom: 1rem;
    }
</style>
