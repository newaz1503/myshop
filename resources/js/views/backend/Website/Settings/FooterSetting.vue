<template>
    <div class="col-lg-12">
        <form v-on:submit.prevent="submit" enctype="multipart/form-data" id="form">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <strong>Site Description</strong>
                                    <textarea

                                        v-model="data.site_description"
                                        name="site_description"
                                        rows="2"
                                        class="form-control"
                                        placeholder="Enter site description"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <strong>Section One</strong>
                                    <div class="form-group col-lg-12">
                                        <label for="">Title</label>
                                        <input v-model="data.footer_section_one_title" type="text"
                                               placeholder="Enter Title" class="form-control"
                                               name="footer_section_one_title">
                                        <span class="text-danger">
                                            {{ validation.firstError("data.footer_section_one_title") }}
                                        </span>
                                    </div>
                                    <p>Links</p>
                                    <div class="form-group row" v-for="(link,index) in data.footer_section_one_links"
                                         :key="index">
                                        <div class="col-lg-4">
                                            <input
                                                type="text"
                                                class="form-control"
                                                :name="`footer_section_one_links[${index}][label]`"
                                                v-model="link.label"
                                            >
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                :name="`footer_section_one_links[${index}][url]`"
                                                v-model="link.url"
                                            >
                                        </div>
                                        <div class="col-lg-2 pt-1 text-center">
                                            <button @click="data.footer_section_one_links.push({})"
                                                    v-if="index == data.footer_section_one_links.length -1"
                                                    type="button" class="avatar-xs btn btn-success btn-sm btn-rounded">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                            <button @click="data.footer_section_one_links.splice(index,1)"
                                                    v-if="data.footer_section_one_links.length > 1" type="button"
                                                    class="avatar-xs btn btn-danger btn-sm btn-rounded">
                                                <i class="mdi mdi-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <strong>Section Two</strong>
                                    <div class="form-group col-lg-12">
                                        <label for="">Title</label>
                                        <input v-model="data.footer_section_two_title" type="text"
                                               placeholder="Enter Title" class="form-control"
                                               name="footer_section_two_title">
                                        <span class="text-danger">
                                            {{ validation.firstError("data.footer_section_two_title") }}
                                        </span>
                                    </div>
                                    <p>Links</p>
                                    <div class="form-group row" v-for="(link,index) in data.footer_section_two_links"
                                         :key="index">
                                        <div class="col-lg-4">
                                            <input
                                                type="text"
                                                class="form-control"
                                                :name="`footer_section_two_links[${index}][label]`"
                                                v-model="link.label"
                                            >
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                :name="`footer_section_two_links[${index}][url]`"
                                                v-model="link.url"
                                            >
                                        </div>
                                        <div class="col-lg-2 pt-1 text-center">
                                            <button @click="data.footer_section_two_links.push({})"
                                                    v-if="index == data.footer_section_two_links.length -1"
                                                    type="button" class="avatar-xs btn btn-success btn-sm btn-rounded">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                            <button @click="data.footer_section_two_links.splice(index,1)"
                                                    v-if="data.footer_section_two_links.length > 1" type="button"
                                                    class="avatar-xs btn btn-danger btn-sm btn-rounded">
                                                <i class="mdi mdi-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12">
                                <strong>Subscription Option</strong>
                                <div class="form-check form-switch form-switch-md my-4" dir="ltr">
                                    <input type="checkbox" name="show_newsletter" value="1" v-model="data.show_newsletter" class="form-check-input"
                                           id="customSwitchsizemd">
                                    <label class="form-check-label" for="customSwitchsizemd">Show Newsletter</label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <strong>Footer Logo (White)</strong>
                                <div class="image-box p-2 rounded border border-dashed w-100">
                                    <div class="no-image text-center py-4 text-muted">
                                        <template v-if="data.white_logo">
                                            <img :src="data.white_logo" alt="">
                                        </template>
                                        <template v-else>
                                            <i class="ri-upload-cloud-2-fill fs-24"></i>
                                            <h6 class="text-muted">No Image</h6>
                                        </template>
                                    </div>
                                    <input
                                        type="file"
                                        class="d-none"
                                        id="white_logo"
                                        name="white_logo"
                                        @change="imageHandler($event,'white_logo')"
                                    >
                                    <label for="white_logo" class="w-100 m-0">
                                        <div class="d-block btn btn-default bg-light border border-dashed w-100">
                                            Choose File
                                        </div>
                                    </label>
                                </div>
                                <span class="text-danger">
                                    {{ validation.firstError("data.white_logo") }}
                                </span>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <strong class="mb-2">Gateway Image</strong>
                                <div class="image-box p-2 rounded border border-dashed w-100">
                                    <div class="no-image text-center py-4 text-muted">
                                        <template v-if="data.getway_image">
                                            <img :src="data.getway_image" alt="">
                                        </template>
                                        <template v-else>
                                            <i class="ri-upload-cloud-2-fill fs-24"></i>
                                            <h6 class="text-muted">No Image</h6>
                                        </template>
                                    </div>
                                    <input
                                        type="file"
                                        class="d-none"
                                        id="getway_image"
                                        name="getway_image"
                                        @change="imageHandler($event,'getway_image')"
                                    >
                                    <label for="getway_image" class="w-100 m-0">
                                        <div class="d-block btn btn-default bg-light border border-dashed w-100">
                                            Choose File
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 py-3 text-center">
                                <button type="submit" :disabled="$root.spinner" class="btn btn-primary btn-border d-block w-100">
                                    <span v-if="$root.spinner"><i class="fa fa-spinner fa-spin"></i> Loading..</span>
                                    <span v-else>Save Changes</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "FooterSetting",
        data() {
            return {
                data: {
                    footerValue: [],
                    white_logo:null,
                    getway_image:null,
                    show_newsletter: 0,
                    footer_section_one_title: '',
                    footer_section_one_links: [
                        {label: '', url: ''}
                    ],
                    footer_section_two_title: '',
                    footer_section_two_links: [
                        {label: '', url: ''}
                    ]
                },
                image:{white_logo:'',getway_image: ''},
                errors: {},
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
                        var form = document.getElementById("form");
                        var formData = new FormData(form);
                        this.$root.spinner = true;
                        axios.post('setting/footer/store', formData).then(res => {
                            this.notification(
                            res.message,
                            "success"
                        );
                        }).catch(error => {
                            console.log(error)
                        }).finally(() => {
                            setTimeout(() => {
                                this.$root.spinner = false;
                            },100);
                        });
                    }
                });
            },
            imageHandler(e,imagePath,fieldClass){
                this.showImage(e, imagePath, imagePath,  fieldClass, null);
            },
        },

        created(){
            axios.get('setting/footer')
            .then(res => {
                this.data = res.data
            })
            .catch(e => {
                console.log(e)
            })

        },

        // ================== validation rule for form ==================
        validators: {
            "data.white_logo": function (value = null) {
                return Validator.value(value).required("Logo is required");
            },
            "data.footer_section_one_title": function (value = null) {
                return Validator.value(value).required("Title is required");
            },
            "data.footer_section_two_title": function (value = null) {
                return Validator.value(value).required("Title is required");
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
