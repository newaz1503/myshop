<template>
  <div>
    <div class="box box-success" v-if="!$root.spinner">
      <div class="box-header with-border">
        <!-- <h3 class="box-title">{{ model + " Create" }}</h3> -->

        <!--============ Add or Back Button Start ============-->
        <AddOrBackButton
          :route="model + '.index'"
          :portion="model"
          :icon="'arrow-left'"
          title="Payment History"
        />
        <!--============ Add or Back Button End ============-->
      </div>

      <div class="box-body box-min-height">
        <!--============ Form Start ============-->
        <div class="row">
          <form
            v-on:submit.prevent="submit"
            enctype="multipart/form-data"
            id="form"
            class="form-row col-12"
          >
            <!------------ Single Input ------------>
            <Input title="Title" field="title" :req="true" />

            <!-------------- button -------------->
            <div class="col-12 mb-3 mt-2">
              <Button title="Submit" process="" />
            </div>
            <!-------------- button -------------->
          </form>
        </div>
        <!--============ Form End ============-->
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "invoice";

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  methods: {
    submit: function () {
      this.notification("Sorry! can't create invoice", "error");
      return false;

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

        // If there is no error
        if (res) {
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id);
          } else {
            this.store(this.model, this.data);
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
      this.setBreadcrumbs(this.model, "create", "Payment History");
    }
  },

  // ================== validation rule for form ==================
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
  },
};
</script>
