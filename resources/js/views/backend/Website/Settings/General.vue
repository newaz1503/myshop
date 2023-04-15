<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">General Settings</h4>
        </div>
        <div class="card-body form-steps">
            <div class="vertical-navs-step">
                <div class="row gy-5">
                    <div class="col-lg-3">
                        <div class="nav flex-column custom-nav nav-pills position-sticky top-20" role="tablist"
                             aria-orientation="vertical">
                            <button class="nav-link active" id="website-setting-tab" data-bs-toggle="pill"
                                    data-bs-target="#website-setting" type="button" role="tab"
                                    aria-controls="website-setting" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="ri-earth-fill me-2"></i> Website Setting
                                </span>
                            </button>
                            <button class="nav-link" id="media-setting-tab" data-bs-toggle="pill"
                                    data-bs-target="#media-setting" type="button" role="tab"
                                    aria-controls="media-setting" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-character-recognition-line me-2"></i> Logo & Icon
                                </span>
                            </button>
                            <button class="nav-link" id="social-link-tab" data-bs-toggle="pill"
                                    data-bs-target="#social-link" type="button" role="tab"
                                    aria-controls="social-link" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-plant-line me-2"></i> Social Link
                                </span>
                            </button>

                            <button class="nav-link" id="working-days-tab" data-bs-toggle="pill"
                                    data-bs-target="#working-days" type="button" role="tab"
                                    aria-controls="working-days" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="bx bx-run me-2"></i> Working Days
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="px-lg-4">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="website-setting" role="tabpanel"
                                     aria-labelledby="website-setting-tab">
                                    <div>
                                        <h5>Website Setting</h5>
                                        <p class="text-muted">Fill all information below</p>
                                    </div>
                                    <form @submit.prevent="websiteSetting" id="websiteSettingForm">
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <label for="firstName" class="form-label">App Name</label>
                                                <input type="text" name="app_name"
                                                       v-model="data.app_name" class="form-control"
                                                       id="firstName" placeholder="Enter app name">
                                            </div>

                                            <div class="col-sm-12">
                                                <label for="lastName" class="form-label">Website Title</label>
                                                <input type="text" name="website_title"
                                                       v-model="data.website_title" class="form-control"
                                                       id="lastName" placeholder="Enter website title">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Store Phone Number </label>
                                                <input type="text" name="store_phone"
                                                       v-model="data.store_phone" class="form-control"
                                                       placeholder="Enter store phone">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Store Email</label>
                                                <input type="text" name="store_email"
                                                       v-model="data.store_email" class="form-control"
                                                       placeholder="Enter store email">
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label">Store Address </label>
                                                <input type="text" name="store_address"
                                                       v-model="data.store_address" class="form-control"
                                                       placeholder="Enter store address">
                                            </div>
                                            <SelectCustom
                                                v-if="currencies"
                                                title="Select Currency"
                                                field="currency"
                                                :req="false"
                                                :datas="currencies"
                                                val="symbol"
                                                val_title="name"
                                                col="12"
                                            />
                                            <div class="col-12">
                                                <label class="form-label">Primary Colour Code</label>
                                                <div class="input-group">
                                                    <input type="color" name="primary_color"
                                                           v-model="data.primary_color" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label">Site Meta Title </label>
                                                <input type="text" class="form-control" name="site_meta_title"
                                                       v-model="data.site_meta_title" >
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label">Site Meta Description </label>
                                                <textarea class="form-control" name="site_meta_description"
                                                          v-model="data.site_meta_description" id=""
                                                          rows="4"></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="lastName" class="form-label">Site Meta Keywords </label>
                                                <input input-id="tags-basic" name="site_meta_keywords" class="form-control"
                                                             v-model="data.site_meta_keywords" />
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" v-model="data.whatsapp_show" value="1"
                                                        class="form-check-input" name="whatsapp_show" id="whatsappShow">
                                                    <label class="form-check-label" for="whatsappShow">show/hide Whatsapp</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Whatsapp number</label>
                                                <input type="number" name="whatsapp_number"
                                                       v-model="data.whatsapp_number" class="form-control"
                                                       placeholder="Enter whatsapp number">
                                            </div>

                                        </div>
                                        <div class="gap-3 mt-4">
                                            <Button type="submit" title="Save Changes"></Button>
                                        </div>
                                    </form>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="media-setting" role="tabpanel"
                                     aria-labelledby="media-setting-tab">
                                    <div>
                                        <h5>Logo & Icon</h5>
                                        <p class="text-muted">Upload Logo, Favicon and Loader</p>
                                    </div>
                                    <form @submit.prevent="storeLogoIconSetting" id="logoIconForm">
                                        <div class="row gy-3">
                                            <div class="col-md-4">
                                                <label for="logo_image" class="form-label file-selectore">
                                                    <input type="file" name="logo" id="logo_image" class="d-none"
                                                           @change="onFileChange($event,'logo')">
                                                    <div class="preview-box">
                                                        <img v-if="data.logo" :src="data.logo" alt="">
                                                        <img v-else-if="image.logo" :src="image.logo" alt="">
                                                        <div v-else class="upload-icon">
                                                            <i class=" ri-upload-cloud-2-fill"></i>
                                                        </div>
                                                        <span class="label">Select Logo</span>
                                                          <div class="mt-3">
                                                              <label class="text-muted mt-2">image size: 80 × 80 px</label>
                                                        </div>

                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="favicon_image" class="form-label file-selectore">
                                                    <input type="file" name="favicon" id="favicon_image" class="d-none"
                                                           @change="onFileChange($event,'favicon',)">
                                                    <div class="preview-box">
                                                        <img v-if="data.favicon" :src="data.favicon" alt="">
                                                        <img v-else-if="image.favicon" :src="image.favicon" alt="">
                                                        <div v-else class="upload-icon">
                                                            <i class=" ri-upload-cloud-2-fill"></i>
                                                        </div>
                                                        <span class="label">Select Favicon</span>

                                                          <div class="mt-3">
                                                             <label class="text-muted mt-2">image size: 20 × 20 px</label>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="loader_image" class="form-label file-selectore">
                                                    <input type="file" name="loader" id="loader_image" class="d-none"
                                                           @change="onFileChange($event,'loader')">
                                                    <div class="preview-box">
                                                        <img v-if="data.loader" :src="data.loader" alt="">
                                                        <img v-else-if="image.loader" :src="image.loader" alt="">
                                                        <div v-else class="upload-icon">
                                                            <i class=" ri-upload-cloud-2-fill"></i>
                                                        </div>
                                                        <span class="label">Select Loader</span>
                                                        <div class="mt-3">
                                                            <label class="text-muted d-block">image size: 60 × 60 px</label>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="gap-3 mt-4">
                                            <Button type="submit" title="Save Changes"></Button>
                                        </div>
                                    </form>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="social-link" role="tabpanel"
                                     aria-labelledby="social-link-tab">
                                    <form @submit.prevent="saveSocialMedia" id="socialMediaForm" class="">
                                        <h5>Social Links </h5>
                                        <div class="social-item row mb-2 align-items-center"
                                             v-for="(media,index) in data.social_links" :key="index">
                                            <div class="social-icon col-lg-2">
                                                <div class="btn-group">
                                                    <button type="button"
                                                            class="btn d-block w-100 btn-primary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="h4 text-white p-0 m-0" :class="media.icon"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a
                                                            class="dropdown-item icon"
                                                            v-for="(icon,key) in mediaIcons"
                                                            :key="key"
                                                            href="javascript:"
                                                            @click="media.icon = icon"
                                                        >
                                                            <i class="h4" :class="icon"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="social-field col-lg-7 px-0">
                                                <input url="url" class="form-control" name="social_links"
                                                       v-model="media.url">
                                            </div>
                                            <div class="col-lg-2">
                                                <a href="javascript:" v-show="index == data.social_links.length - 1"
                                                   @click="data.social_links.push({url:'',icon:''})"
                                                   class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                <a href="javascript:" v-show="data.social_links.length > 1"
                                                   @click="data.social_links.splice(index,1)"
                                                   class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                        <div class="gap-3 mt-4">
                                            <Button type="submit" title="Save Changes"></Button>
                                        </div>
                                    </form>
                                </div>

                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="working-days" role="tabpanel"
                                     aria-labelledby="working-days-tab">
                                    <div class="">
                                        <h5>Working Days</h5><br>
                                        <form @submit.prevent="saveWorkingDay" id="workingDayForm" class="">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="friday_start">Monday-Friday from </label>
                                                        <input type="time" name="friday_start"
                                                               v-model="data.friday_start"
                                                               class="form-control timepicker" id="friday_start"
                                                               placeholder="Monday-Friday from">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="friday_end">Till </label>
                                                        <input type="time" name="friday_end" v-model="data.friday_end"
                                                               class="form-control timepicker" id="friday_end"
                                                               placeholder="Till">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="satureday_start">Saturday-Sunday from </label>
                                                        <input type="time" name="satureday_start"
                                                               v-model="data.satureday_start"
                                                               class="form-control timepicker" id="satureday_start"
                                                               placeholder="Saturday-Sunday from">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="satureday_end">Till </label>
                                                        <input type="time" name="satureday_end"
                                                               v-model="data.satureday_end"
                                                               class="form-control timepicker" id="satureday_end"
                                                               placeholder="Till">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gap-3 mt-4">
                                                <Button type="submit" title="Save Changes"></Button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                            </div>
                            <!-- end tab content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const model = "siteSetting";
    export default {
        name: "General",
        data() {
            return {
                model: model,
                data: {
                    app_name: '',
                    website_title: '',
                    primary_color: '',
                    currency: null,
                    site_meta_keywords: [],
                    site_meta_description: '',
                    active_theme: 'theme_one',
                    site_meta_title : '',
                    friday_end: "20:00",
                    friday_start: "10:00",
                    satureday_end: "17:30",
                    satureday_start: "22:13",
                    whatsapp_number: '',
                    whatsapp_show: '',

                    logo: '',
                    favicon: '',
                    loader: '',
                    getway_image: '',
                    social_links: [
                        {url: 'https://www.facebook.com/', icon: 'fa fa-facebook'},
                    ]
                },
                image: {
                    logo: '',
                    favicon: '',
                    loader: '',
                    getway_image: '',
                },
                currencies: [
                    {"symbol": "$", "code": "USD",  "name": "($) US Dollar" },
                    {"symbol": "CA$", "code": "CAD", "name": "(CA$) Canadian Dollar" },
                    {"symbol": "€", "code": "EUR", "name": "(€) Euro" },
                    {"symbol": "AED", "code": "AED", "name": "(AED) United Arab Emirates Dirham" },
                    {"symbol": "AU$", "code": "AUD", "name": "(AU$) Australian Dollar" },
                    {"symbol": "Rs", "code": "INR", "name": "(Rs) Indian Rupee" },
                    {"symbol": "PKRs", "code": "PKR", "name": "(PKRs) Pakistani Rupee" },
                    {"symbol": "CN¥", "code": "CNY", "name": "(CN¥) Chinese Yuan" },
                    {"symbol": "QR", "code": "QAR", "name": "(QR) Qatari Rial" },
                    {"symbol": "Tk", "code": "BDT", "name": "(Tk) Bangladeshi Taka" },
                ],
                mediaIcons: [
                    'fa fa-firefox',
                    'fa fa-facebook',
                    'fa fa-whatsapp',
                    'fa fa-linkedin',
                    'fa fa-youtube',
                    'fa fa-twitter',
                    'fa fa-skype',
                    'fa fa-google-plus',
                    'fa fa-github',
                    'fa fa-pinterest',
                    'fa fa-stack-overflow',
                ]
            };
        },
        methods: {
            submit: function () {
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
                        var form = document.getElementById("form");
                        var formData = new FormData(form);
                        if (this.image.logo) {
                            formData.append("logo", this.image.logo);
                        } else {
                            formData.append("logo", "");
                        }
                        if (this.image.favicon) {
                            formData.append("favicon", this.image.favicon);
                        } else {
                            formData.append("favicon", "");
                        }
                        if (this.image.loader) {
                            formData.append("loader", this.image.loader);
                        } else {
                            formData.append("loader", "");
                        }
                        this.store(this.model, formData);
                    }
                });
            },
            onFileChange(e, model, fileClass, pdf = null) {
                this.showImage(e, model, model, fileClass, pdf); // 1st data image, second show image
            },
            storeSetting(url, data) {
                this.$root.spinner = true;
                this.$root.submit = true;
                axios.post(url, data).then(res => {
                    this.notification(res.data.message, "success");
                }).catch(error => {
                    console.log(error);
                }).finally(() => {
                    setTimeout(() => {
                        this.$root.spinner = false;
                        this.$root.submit = false;
                    }, 100);
                });
            },
            websiteSetting() {
                var form = document.getElementById("websiteSettingForm");
                var formData = new FormData(form);
                if (this.data.site_meta_keywords) {
                    formData.append("site_meta_keywords", this.data.site_meta_keywords);
                } else {
                    formData.append("site_meta_keywords", "");
                }
                this.storeSetting('setting/general/website-settings', formData)
            },
            storeLogoIconSetting() {
                var form = document.getElementById("logoIconForm");
                var formData = new FormData(form);
                this.storeSetting('setting/general/logo-icon', formData)
            },
            saveSocialMedia() {
                this.storeSetting('setting/general/social-media', this.data.social_links)
            },
            saveWorkingDay() {
                var form = document.getElementById("workingDayForm");
                var formData = new FormData(form);
                this.storeSetting('setting/general/working-day', formData)
            },

            getSettings() {
                axios.get('setting/general-settings').then(res => {
                    this.data = res.data;
                });
            }
        },
        async created() {
            if (this.$route.params.id) {
                this.setBreadcrumbs(this.model, "edit", "Site Setting");
                this.get_data(this.model, this.$route.params.id, "data");
            } else {
                this.setBreadcrumbs(this.model, "create", "Site Setting");
            }
            await this.getSettings();
        },

        // ================== validation rule for form ==================
        validators: {
            "data.title": function (value = null) {
                return Validator.value(value).required("Title is required");
            },
            "data.short_title": function (value = null) {
                return Validator.value(value).required("Short Title is required");
            },
            "data.logo": function (value = null) {
                return Validator.value(value).required("Logo is required");
            },
        },
    };
</script>
<style lang="scss">
    li.badge.b-form-tag {
        background: #e0e0e0;
        margin: 2px 2px;
        border-radius: 0px;

        span.b-form-tag-content {
            font-size: 12px;
            margin: 0 7px;
            color: #444;
        }

        button.close.b-form-tag-remove {
            font-size: 13px;
            border: 0;
            padding: 0;
            background: red;
            color: #fff;
            border-radius: 2px;
            height: 17px;
            width: 17px;
            text-align: center;
        }
    }

    label.form-label.theme-selector {
        border: 2px solid transparent;
        border-radius: 5px;
        overflow: hidden;
        transition: .6s;
        position: relative;
        cursor: pointer;

        span.status {
            top: -20px;
            opacity: 0;
            transition: .7s;
            visibility: hidden;
            background: #009688;
            position: absolute;
            right: 0;
            margin: 10px;
            padding: 6px 18px;
            border-radius: 3px;
            color: #fff;
            z-index: -1;
        }

        &.active {
            border: 2px solid #009688;

            span.status {
                top: 0px;
                opacity: 1;
                visibility: visible;
                z-index: 99;
            }
        }
    }

    label.form-label.file-selectore {
        width: 100%;
        border: 2px dashed #087e734d;
        text-align: center;
        padding: 30px 10px;
        border-radius: 10px;
        font-size: 15px;
        height: 180px;
        cursor: pointer;

        .upload-icon {
            font-size: 40px;
            color: #20aa9ead;
        }


        .preview-box {
            height: 110px;

            img {
                width: 100%;
                height: 100%;
            }

            span.label {
                color: #444444bd;
            }
        }
    }

    .top-20 {
        top: 20%;
    }

    .social-icon .btn-group {
        width: 75px;
    }
</style>
