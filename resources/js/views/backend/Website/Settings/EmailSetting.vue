<template>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Email Settings</h4>
            </div>
            <div class="card-body form-steps">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form @submit.prevent="submit" id="websiteSettingForm">
                            <div class="row g-3">
                                <Select
                                    v-if="emailEngine"
                                    title="Type"
                                    field="smtp_engine"
                                    :req="true"
                                    :datas="emailEngine"
                                    col="12"
                                />
                                <Input title="MAIL HOST" col="12" field="mail_host" type="text" :req="true"/>
                                <Input title="MAIL PORT" col="12" field="mail_port" type="text" :req="true"/>
                                <Input title="MAIL USERNAME" col="12" field="mail_username" type="text" :req="true"/>
                                <Input title="MAIL PASSWORD" col="12" field="mail_password" type="text" :req="true"/>
                                <Input title="MAIL ENCRYPTION" col="12" field="mail_encryption" type="text" :req="true"/>
                                <Input title="MAIL FROM ADDRESS" col="12" field="mail_from_address" type="text" :req="true"/>
                                <Input title="MAIL FROM NAME" col="12" field="mail_from_name" type="text" :req="true"/>

                            </div>
                            <div class="gap-3 mt-4">
                                <Button title="Save Changes" process="" />
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FooterSetting",
        data() {
            return {
                data: {
                    smtp_engine: 'smtp',
                },
                emailEngine: {
                    sendmail: "SendMail",
                    smtp: "SMTP",
                },
            }
        },
        methods: {
            submit: function () {
                const error = this.validation.countErrors();
                this.$validate().then((res) => {
                    // If there is an error
                    if (error > 0) {
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "error"
                        );
                        return false;
                    }
                    //If there is no error
                    if (res) {
                        axios.post('setting/email/setting/store', this.data).then(res => {
                            this.notification(
                                res.message,
                                "success"
                            );
                        }).catch(error => {
                            console.log(error)
                        }).finally(() => {
                            setTimeout(() => {
                                this.$root.spinner = false;
                            }, 100);
                        });
                    }
                });
            },
        },
        created() {
            axios.get('setting/email/setting').then(res => {
                this.data = res.data;
            })
            this.setBreadcrumbs('Email Settings');
        },
        // ================== validation rule for form ==================
        validators: {
            "data.smtp_engine": function (value = null) {
                return Validator.value(value).required("SMTP Engine is required");
            },
            "data.mail_host": function (value = null) {
                return Validator.value(value).required("Mail Host is required");
            },
            "data.mail_port": function (value = null) {
                return Validator.value(value).required("Mail Port is required");
            },
            "data.mail_username": function (value = null) {
                return Validator.value(value).required("Mail Username is required");
            },
            "data.mail_password": function (value = null) {
                return Validator.value(value).required("Mail Password is required");
            },
            "data.mail_encryption": function (value = null) {
                return Validator.value(value).required("Mail Encryption is required");
            },
            "data.mail_from_address": function (value = null) {
                return Validator.value(value).required("Mail From Address is required");
            },
            "data.mail_from_name": function (value = null) {
                return Validator.value(value).required("Mail From Name is required");
            },
        },
    }
</script>

<style scoped>
    .no-image img {
        height: 100px;
        width: 100px;
        object-fit: contain;
    }
</style>

