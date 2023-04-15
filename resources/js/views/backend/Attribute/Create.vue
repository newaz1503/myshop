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
                    <Input title="Name" col="4" field="name" :req="true"/>
                    <!------------ Single Input ------------>
                    <Input
                        title="Sorting"
                        field="sorting"
                        type="text"
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
                    <div class="col-sm-">
                        <label for="lastName" class="form-label">Attribute</label>
                        <b-form-tags input-id="tags-basic"
                                     v-model="data.values">
                        </b-form-tags>
                    </div>

                    <!-------------- button -------------->
                    <div class="col-12 mb-3 mt-4">
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
const model = "attribute";

export default {
  data() {
    return {
      model: model,
      data: {
          name:'',
          values:[],
          status:'active',
          sorting:0,
      },
    };
  },
  methods: {
    submit: function () {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        // If there is an error
        if (error > 0) {
          console.log(this.validation.allErrors());
          console.log(this.validation.allErrors());
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
      this.setBreadcrumbs(this.model, "create");
    }
  },

  // ================== validation rule for form ==================
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
    "data.values": function (value = null) {
      return Validator.value(value).required("Values is required");
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
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
</style>
