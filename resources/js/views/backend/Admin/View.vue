<template>
  <section class="content" v-if="!$root.spinner">
    <div class="row">
        <div class="col-lg-4">
            <div class="card text-center" v-if="data" >
                <img
                    class="profile-user-img img-responsive rounded-circle d-flex align-item-center "
                    :src="data.profile ? data.profile : $root.userimage"
                    alt="User profile picture"
                />
                <div class="card-body pt-3">
                    <h3 class="profile-username text-center">{{ data.name }}</h3>
                    <p class="text-muted text-center" v-if="data.role">
                        {{ data.role.name }}
                    </p>
                    <p><i class="fa fa-envelope-o "></i> {{ data.email }} </p>
                    <p><i class="fa fa-phone"></i> {{ data.mobile }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
           <div class="card">
               <div class="card-header">
                   <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                       <li class="nav-item">
                           <a
                               href="#settings"
                               @click="passwordOption(false)"
                               class="nav-link active text-black"
                               data-toggle="tab"
                           >Settings</a
                           >
                       </li>
                       <li class="nav-item">
                           <a
                               href="#change-password"
                               @click="passwordOption(true)"
                               class="nav-link text-black"
                               data-toggle="tab"
                           >Change Password</a
                           >
                       </li>
                   </ul>
               </div>
               <div class="card-body">
                   <div class="nav-tabs-custom">
                       <div class="tab-content">
                           <div class="active tab-pane" id="settings">
                               <form
                                   v-on:submit.prevent="updateInformation"
                                   enctype="multipart/form-data"
                                   id="updateInfoForm"
                                   class="row border rounded border-default m-1 p-2"
                               >
                                   <div class="row flex-column">


                                       <div
                                           class="form-group mb-2 col-6"
                                           :class="{
                    'has-error': validation.hasError('data.name'),
                    '': data.name,
                  }"
                                       >
                                           <label class="control-label">Name</label>
                                           <input
                                               type="text"
                                               name="name"
                                               v-model="data.name"
                                               class="form-control form-control-sm"
                                               placeholder="Name"
                                           />
                                           <span class="help-block">{{
                    validation.firstError("data.name")
                  }}</span>
                                       </div>
                                       <!------------ Single Input ------------>
                                       <div
                                           class="form-group mb-2 col-6"
                                           :class="{
                    'has-error': validation.hasError('data.mobile'),
                    '': data.mobile,
                  }"
                                       >
                                           <label class="control-label">Mobile</label>
                                           <input
                                               type="text"
                                               name="mobile"
                                               v-model="data.mobile"
                                               class="form-control form-control-sm"
                                               placeholder="Mobile"
                                           />
                                           <span class="help-block">{{
                    validation.firstError("data.mobile")
                  }}</span>
                                       </div>


                                       <!------------ Single Input ------------>
                                       <div
                                           class="form-group mb-2 col-6"
                                           :class="{ '': data.profile }"
                                       >
                                           <label class="control-label">Profile</label>
                                           <b-form-file
                                               v-model="image.profile"
                                               accept="image/*"
                                               id="file-small"
                                               size="sm"
                                               class="file1"
                                               v-on:change="onFileChange($event, 'profile', 'file1')"
                                               drop-placeholder="Drop file here"
                                           ></b-form-file>
                                       </div>
                                       <!------------ Single Input ------------>
                                       <div class="form-group mb-2 col-6 pt-3">
                                           <Button title="Update Information" process="" />
                                       </div>
                                   </div>
                               </form>
                           </div>
                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="change-password">
                               <form
                                   v-on:submit.prevent="changePassword"
                                   class="row border rounded border-default m-1 p-2"
                               >
                                   <div class="row g-2">
                                       <!------------ Single Input ------------>
                                       <div
                                           class="form-group  col-lg-4"
                                           :class="{
                    'has-error': validation.hasError(
                      'change_pass.old_password'
                    ),
                    'has-success': change_pass.old_password,
                  }"
                                       >
                                           <label class="control-label">Old Password</label>
                                           <input
                                               v-model="change_pass.old_password"
                                               type="password"
                                               class="form-control form-control-sm"
                                               placeholder="Old Password"
                                           />
                                           <span class="help-block">{{
                    validation.firstError("change_pass.old_password")
                  }}</span>
                                       </div>

                                       <slot v-if="pass_verify">
                                           <!------------ Single Input ------------>

                                           <div
                                               class="form-group mb-2 col-lg-4"
                                               :class="{
                      'has-error': validation.hasError(
                        'change_pass.new_password'
                      ),
                      'has-success': change_pass.new_password,
                    }"
                                               v-if="pass_verify"
                                           >
                                               <label class="control-label">New Password</label>
                                               <input
                                                   v-model="change_pass.new_password"
                                                   type="password"
                                                   class="form-control form-control-sm"
                                                   placeholder="New Password"
                                               />
                                               <span class="help-block">{{
                      validation.firstError("change_pass.new_password")
                    }}</span>
                                           </div>
                                           <!------------ Single Input ------------>
                                           <div
                                               class="form-group mb-2 col-lg-4"
                                               :class="{
                      'has-error': validation.hasError(
                        'change_pass.confirm_password'
                      ),
                      'has-success': change_pass.confirm_password,
                    }"
                                               v-if="pass_verify"
                                           >
                                               <label class="control-label">Confirm Password</label>
                                               <input
                                                   v-model="change_pass.confirm_password"
                                                   type="password"
                                                   class="form-control form-control-sm"
                                                   placeholder="Confirm Password"
                                               />
                                               <span class="help-block">{{
                      validation.firstError("change_pass.confirm_password")
                    }}</span>
                                           </div>

                                       </slot>
                                       <!------------ Single Input ------------>

                                   </div>

                                   <div class="form-group mb-2 col-6 pt-3">
                                       <div class="text-start pt-4 ml-0">
                                           <Button title="Change Password" process="" />
                                       </div>

                                   </div>
                               </form>
                           </div>
                           <!-- /.tab-pane -->
                       </div>
                       <!-- /.tab-content -->
                   </div>
                   <!-- /.nav-tabs-custom -->
               </div>
           </div>
        </div>
    </div>
    <!-- /.row -->
  </section>
</template>

<script>
// ===============Promise===============
import Promise from "bluebird";
// define model name
const model = "admin";

export default {
    name:"View",
  data() {
    return {
      model: model,
      role_name: "",
      image: {},
      data: [],
      password_option: false,
      pass_verify: false,
      change_pass: {},
    };
  },
  methods: {
    updateInformation() {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        if (res) {
          this.$root.submit = true;
          var form = document.getElementById("updateInfoForm");
          var formData = new FormData(form);
          formData.append("_method", "put");
          if (this.image.profile) {
            formData.append("profile", this.image.profile);
          } else {
            formData.append("profile", "");
          }
          axios
            .post("/admin/" + this.$route.params.id, formData)
            .then((res) => {
              this.notification(res.data.message, "success");
              this.get_data(this.model, this.$route.params.id, "data");

              setTimeout(() => {
                profile.dispatch("setProfile", this.data.profile);
              }, 400);
            })
            .catch((error) => console.log(error))
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
    onFileChange(e, model, fileClass, pdf = null) {
      this.showImage(e, model, model, fileClass, pdf);
    },
    passwordOption(type) {
      this.password_option = type;
    },
    changePassword() {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        if (res) {
          this.$root.submit = true;
          axios
            .post("/change-password", this.change_pass)
            .then((res) => {
              this.notification(res.data.message, "success");
              Admin.logout();
            })
            .catch((error) => console.log(error))
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
  },
  created() {
    this.role_name = Admin.role();
    this.change_pass.id = this.$route.params.id;
    this.get_data(this.model, this.$route.params.id, "data"); // get data
    this.setBreadcrumbs(this.model, "view"); // Set Breadcrumbs
  },

  // ================== validation rule for form ==================
  validators: {
    "data.name": function (value = null) {
      if (!this.password_option) {
        return Validator.value(value).required("Name is required");
      }
    },
    "data.mobile": function (value = null) {
      if (!this.password_option) {
        return Validator.value(value)
          .digit()
          .regex("01+[0-9+-]*$", "Must start with 01.")
          .minLength(11)
          .maxLength(15);
      }
    },
    "change_pass.old_password": function (value = null) {
      var app = this;
      if (this.password_option) {
        return Validator.value(value)
          .required("Old password is required")
          .minLength(6)
          .custom(function () {
            if (!Validator.isEmpty(value)) {
              app.$root.submit = true;
              axios.post("/check-old-password", app.change_pass).then((res) => {
                if (res.data) {
                  app.pass_verify = true;
                } else {
                  app.pass_verify = false;
                  return "Old password do not match our records!!";
                }
              });
              return Promise.delay(2000).then(function () {
                if (!app.pass_verify) {
                  return "Old password do not match our records!!";
                }
                app.$root.submit = false;
              });
            }
          });
      }
    },
    "change_pass.new_password": function (value = null) {
      if (this.password_option && this.pass_verify) {
        return Validator.value(value)
          .required("New password is required")
          .minLength(6);
      }
    },
    "change_pass.confirm_password, change_pass.new_password": function (
      confirm_password = null,
      new_password = null
    ) {
      if (this.password_option && this.pass_verify) {
        return Validator.value(confirm_password)
          .required("Password confirmation is required")
          .match(new_password);
      }
    },
  },
};
</script>

<style scoped>
.admin-card{
    width: 18rem;
}
.profile-user-img{
    height: 200px;
    width: 200px;
    margin: 9px auto;

}
</style>
