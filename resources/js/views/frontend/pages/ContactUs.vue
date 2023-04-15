<template>
    <section id=contact_page class="footer_get_touch_outer">
        <div class="container">
            <div class="footer_get_touch_inner grid-70-30">
                <div class="colmun-70 get_form">
                    <div class="get_form_inner">
                        <div class="get_form_inner_text">
                            <h3>Get In Touch</h3>
                        </div>
                        <form @submit.prevent="sendContactMail">
                            <div class="row">
                                <Input
                                    title="First Name"
                                    col="6"
                                    field="first_name"
                                    :req="true">
                                </Input>
                                 <Input
                                    title="Last Name"
                                    col="6"
                                    field="last_name"
                                    :req="true">
                                </Input>
                                 <Input
                                    title="Eamil"
                                    col="6"
                                    field="email"
                                    :req="true">
                                </Input>
                                 <Input
                                    title="Phone"
                                    col="6"
                                    field="phone"
                                    :req="true">
                                </Input>
                                 <Input
                                    title="Subject"
                                    col="12"
                                    field="subject"
                                    :req="true">
                                </Input>
                                 <!------------ Single Input ------------>
                                <Textarea title="Comment" field="comment" :req="true" col="12" />
                                 <div class="mt-4">
                                    <button type="submit" :disabled="btnLoader" class="btn btn-primary btn-border">
                                        <i v-if="btnLoader" class="mdi mdi-sync"></i> Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="colmun-30 get_say_form">
                    <h5>Contact Us</h5>
                    <ul class="get_say_info_sec">
                        <li v-if="contactData.store_address">
                            <i class="bx bx-location-plus"></i>
                            <a href="javascript:void(0)">{{ contactData.store_address }}</a>
                        </li>
                        <li v-if="contactData.store_email">
                            <i class="bx bx-envelope"></i>
                            <a href="mailto:">{{ contactData.store_email }}</a>
                        </li>
                        <li v-if="contactData.store_phone">
                            <i class="bx bx-phone"></i>
                            <a href="tel:">{{ contactData.store_phone }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "ContactUs",
        data() {
            return {
                btnLoader: false,
                data: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    subject: '',
                    comment: '',
                },
                errors: [],
                contactData: []
            }
        },
        mounted() {
            this.getContactData()
        },
        methods: {
            sendContactMail() {
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
                        axios.post('/contact-store', this.data).then(res => {
                            this.notification('Email has been sent!', "success");
                        }).catch(error => {
                            console.log(error)
                        }).finally(() => {
                            this.btnLoader = false;
                        });
                    }
                });
            },
            getContactData() {
                axios.get('/global-footer')
                    .then(response => {
                        this.contactData = response.data
                    })
                    .catch(e => {
                        console.log(e);
                    })
            }
        },
        validators: {
            "data.first_name": function (value = null) {
                return Validator.value(value).required("First Name is required");
            },
            "data.last_name": function (value = null) {
                return Validator.value(value).required("Last Name is required");
            },
            "data.email": function (value = null) {
                return Validator.value(value).required("Email is required");
            },
            "data.phone": function (value = null) {
                return Validator.value(value).required("Phone is required");
            },
            "data.subject": function (value = null) {
                return Validator.value(value).required("Subject is required");
            },
            "data.comment": function (value = null) {
                return Validator.value(value).required("Comment is required");
            }
        },
    }
</script>

<style scoped>
    .footer_get_touch_outer {
        margin: 35px 0;
    }

    .container {
        width: 95%;
        max-width: 1140px;
        margin: auto;
    }

    .grid-70-30 {
        display: grid;
        grid-template-columns: 70% 30%;
    }

    .get_form_inner {
        display: block;
        padding: 50px 40px;
        background: #fff;
        box-shadow: -4px -2px 20px -7px #cfd5df;
    }

    input[type="text"], input[type="text"], input[type="email"], input[type="tel"] {
        border: 1px solid #dbdbdb;
        border-radius: 2px;
        color: #333;
        height: 42px;
        padding: 0 0 0 20px;
        width: 100%;
        outline: 0;
    }

    .grid-50-50 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 20px;
    }

    .grid-full {
        margin: 20px 0;
    }

    textarea {
        border: 1px solid #dbdbdb;
        border-radius: 2px;
        color: #333;
        padding: 12px 0 0 20px;
        width: 100%;
        outline: 0;
        margin-bottom: 20px;
    }

    .get_form_inner_text h3 {
        color: #333;
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 40px;
    }

    input[type="submit"] {
        display: inline-block;
        font-size: 16px;
        text-transform: uppercase;
        background: transparent;
        border: 2px solid;
        font-weight: 500;
        padding: 10px 20px;
        outline: 0;
        cursor: pointer;
        color: #103e65;
        transition: all 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -webkit-transition: all 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -moz-transition: all 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -ms-transition: all 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -o-transition: all 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
    }

    input[type="submit"]:hover {
        background-color: #f85508;
        border-color: #f85508;
        color: #fff;
    }

    .get_say_form {
        display: inline-block;
        padding: 45px 0 25px 30px;
        background: #103e65;
        position: relative;
    }

    .get_say_form h5 {
        color: #fff;
        font-size: 26px;
        margin: 0 0 40px;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .get_say_social-icn {
        display: flex;
        position: absolute;
        bottom: 40px;
    }

    .get_say_social-icn a {
        font-size: 22px;
        color: #fff;
        padding: 0 20px 0 0;
    }

    .get_say_info_sec i {
        color: #fff;
        font-size: 32px;
    }

    .get_say_info_sec > li {
        display: grid;
        grid-template-columns: 40px auto;
        align-items: center;
        margin-bottom: 40px;
    }

    .get_say_info_sec > li a {
        width: 100%;
        display: block;
        padding: 15px 25px;
        color: #fff;
        font-size: 16px;
        text-decoration: unset;
        font-weight: 500;
        background: #162b65;
        border-radius: 5px 0 0 5px;
        transition: background 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -webkit-transition: background 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -moz-transition: background 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -ms-transition: background 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
        -o-transition: background 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19);
    }

    .get_say_info_sec > li a:hover {
        background-color: #f85508;
    }


</style>


