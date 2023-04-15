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
                        field="image"
                        mime="img"
                        :req="true"
                        fileClassName="file1"
                    />
                    <!------------ Single Input ------------>
                    <Input
                        title="Title"
                        field="title"
                        type="text"
                        col="4"
                        :req="true"
                    />
                    <!------------ Single Input ------------>
                    <Input
                        title="Sorting"
                        field="sorting"
                        type="text"
                        :req="true"
                        col="2"
                    />
                    <!------------ Single Input ------------>
                    <Textarea title="Description" field="description" :req="true" col="12" />
                    <!-------------- button -------------->
                    <div class="col-12 mb-3 mt-3">
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
const model = "service";

export default {
    data() {
        return {
            model: model,
            data: {image: "", sorting: 0},
            image: {},
            errors: {},
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
                    if (this.data.description) {
                        formData.append("description", this.data.description);
                    } else {
                        formData.append("description", "");
                    }
                    if (this.data.id) {
                        this.update(this.model, formData, this.data.id, "image");
                    } else {
                        this.store(this.model, formData);
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
            this.get_sorting("Service");
        }
    },

    // ================== validation rule for form ==================
    validators: {
        "data.title": function (value = null) {
            return Validator.value(value).required("Title is required");
        },
        "data.image": function (value = null) {
            return Validator.value(value).required("Image is required")
        },
        "data.description": function (value = null) {
            return Validator.value(value).required("Description is required")
        },
        "data.sorting": function (value = null) {
            return Validator.value(value).required("Sorting is required");
        },
    },
};
</script>
