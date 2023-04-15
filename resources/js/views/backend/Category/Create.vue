<template>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3 justify-content-end">
                <div class="col-lg-2 text-end order-last offset-2">
                    <!--============ Add or Back Button Start ============-->
                    <AddOrBackButton
                        :route="model + '.index'"
                        :portion="model"
                        :icon="'arrow-left'"
                    />
                </div>
            </div>
            <div class="form">
                <form
                    v-on:submit.prevent="submit"
                    enctype="multipart/form-data"
                    id="form"
                    class="row"
                >
                    <!------------ Single Custom Select ------------>
                    <div class="col-4">
                        <label for="">Parent Category</label>
                        <v-select
                            :options="parents"
                            :reduce="category => category.id"
                            label="title"
                            v-model="data.parent_id"
                        />
                    </div>
                    <div class="col-4">
                        <label for="">Sub Category</label>
                        <v-select
                            :options="subCategories"
                            :reduce="sub_category => sub_category.id"
                            label="title"
                            v-model="data.sub_category_id"
                        />
                    </div>
                    <!------------ Single Input ------------>
                    <Input title="Title" field="title" :req="true"/>

                    <!------------ Single Input ------------>
                    <File
                        title="Image"
                        field="image"
                        mime="img"
                        :req="false"
                        fileClassName="file1"
                    />

                    <!------------ Single Input ------------>
                    <Input
                        title="Sorting"
                        field="sorting"
                        type="number"
                        :req="true"
                        col="2"
                    />
                    <!------------ Single Input ------------>
                    <Radio
                        title="Status"
                        field="status"
                        statusTitle1="Active"
                        statusTitle2="Deactive"
                        value1="active"
                        value2="deactive"
                        :req="true"
                        col="3"
                    />
                    <Meta />

                    <!-------------- button -------------->
                    <div class="col-12 mb-3 mt-2">
                        <Button title="Submit" process=""/>
                    </div>
                    <!-------------- button -------------->
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    // define model name
    const model = "category";

    export default {
        data() {
            return {
                model: model,
                data: {
                    parent_id:'',
                    sub_category_id:'',
                    image: "",
                    sorting: 0,
                    status: 'active',
                    is_meta: false,
                },
                image: {},
                errors: {},
                parents: [],
                subCategories: [],
            }
        },
        watch: {
            'data.parent_id'(value){
                this.getSubCategories(value);
            }
        },
        methods: {
            submit: function () {
                this.$validate().then((res) => {
                    const error = this.validation.countErrors();
                    // If there is an error
                    if (error > 0) {
                        console.log(this.validation.allErrors());
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "warning"
                        );
                        return false;
                    }
                    // If there is no error
                    if (res) {
                        let form = document.getElementById("form");
                        let formData = new FormData(form);
                        if (this.data.parent_id){
                            formData.append('parent_id',this.data.parent_id);
                        }
                        if (this.data.sub_category_id){
                            formData.append('sub_category_id',this.data.sub_category_id);
                        }
                        if (this.data.slug) {
                            this.update(this.model, formData, this.data.slug,"image");
                        } else {
                            this.store(this.model, formData);
                        }
                    }
                });
            },
            getSubCategories(id){
                axios.get('get-sub-categories/'+id).then(res => {
                    this.subCategories  =  res.data;
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        created() {
            if (this.$route.params.id) {
                this.setBreadcrumbs(this.model, "edit");
                this.get_data(this.model, this.$route.params.id, "data");
            } else {
                this.setBreadcrumbs(this.model, "create");
                this.get_sorting("Category");
            }
            axios.get('categories').then(res => {
                this.parents  =  res.data;
            }).catch(error => {
                console.log(error);
            });
        },

        // ================== validation rule for form ==================
        validators: {
            "data.title": function (value = null) {
                return Validator.value(value).required("Title is required");
            },
            "data.status": function (value = null) {
                return Validator.value(value).required("Status is required");
            },
        },
    };
</script>
