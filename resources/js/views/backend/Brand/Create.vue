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
                    <!------------ Single Input ------------>
                    <File
                        title="Image"
                        field="icon"
                        mime="img"
                        :req="true"
                        fileClassName="file1"
                    />
                    <!------------ Single Input ------------>
                    <Input title="Name" field="name" :req="true"/>
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
    const model = "brand";

    export default {
        data() {
            return {
                model: model,
                data: {
                    icon: "",
                    sorting: 0,
                    status: 'active',
                },
                image: {},
                errors: {},
            };
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
                        if (this.data.slug) {
                            this.update(this.model, formData, this.data.slug,'image');
                        } else {
                            this.store(this.model,formData);
                        }
                    }
                });
            },
        },
        created() {
            if (this.$route.params.id) {
                this.setBreadcrumbs(this.model, "edit");
                this.get_data(this.model, this.$route.params.id, "data");
            } else {
                this.setBreadcrumbs(this.model, "create");
                this.get_sorting("Brand");
            }
        },

        // ================== validation rule for form ==================
        validators: {
            "data.name": function (value = null) {
                return Validator.value(value).required("Name is required");
            },
            "data.icon": function (value = null) {
                return Validator.value(value).required("Icon is required");
            },
            "data.status": function (value = null) {
                return Validator.value(value).required("Status is required");
            },
        },
    };
</script>
