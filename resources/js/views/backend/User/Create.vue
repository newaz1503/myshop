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
                    <Input title="Name" field="name" type="text" :req="true"/>
                    <Input title="Email" field="email" type="text" :req="true"/>
                    <Input title="Mobile" field="mobile" type="number" :req="true"/>
                    <div class="col-3 form-group" :class="{
                                'has-error': validation.hasError('data.country_id'),
                                'has-success': data.country_id,
                              }">
                        <label for="">Select Country</label>
                        <v-select
                            :options="options.countries"
                            :reduce="country => country.country_id"
                            label="name"
                            v-model="data.country_id"
                        />
                        <span class="help-block">
                            {{ validation.firstError("data.country_id") }}
                          </span>
                    </div>
                    <div class="col-3 form-group">
                        <label for="">Select State</label>
                        <v-select
                            :options="options.states"
                            :reduce="state => state.id"
                            label="name"
                            v-model="data.state_id"
                        />
                    </div>
                    <div class="col-3 form-group" :class="{
                                'has-error': validation.hasError('data.city_id'),
                                'has-success': data.city_id,
                              }">
                        <label for="">Select City</label>
                        <v-select
                            :options="options.cities"
                            :reduce="city => city.id"
                            label="name"
                            v-model="data.city_id"
                        />
                        <span class="help-block">
                            {{ validation.firstError("data.city_id") }}
                          </span>
                    </div>
                    <Input
                        title="Postal Code"
                        field="postal_code"
                        type="number" col="3"
                        :req="true"
                    />
                    <Textarea title="Address" field="address" :req="true" col="12" />
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
    const model = "user";

    export default {
        data() {
            return {
                model: model,
                data: {
                    country_id:null,
                    state_id:null,
                    city_id:null,
                },
                options: {
                    customers: [],
                    countries: [],
                    states: [],
                    cities: [],
                }
            };
        },
        watch:{
            'data.country_id'(countryId) {
                this.getStates(countryId);
                this.getCities(countryId);
            },
            'data.state_id'(stateId) {
                this.getCities(this.data.country_id, stateId);
            },
        },
        methods: {
            submit: function () {
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
            getStates(countryId) {
                axios.get('states', {params: {country_id: countryId}}).then(res => {
                    this.options.states = res.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            getCities(countryId, stateId = null) {
                let params = {
                    country_id: countryId,
                    state_id: stateId
                }
                axios.get('cities', {params: params}).then(res => {
                    this.options.cities = res.data;
                }).catch(error => {
                    console.log(error)
                })
            },
        },
        created() {
            if (this.$route.params.id) {
                this.setBreadcrumbs(this.model, "edit");
                this.get_data(this.model, this.$route.params.id, "data");
            } else {
                this.setBreadcrumbs(this.model, "create");
            }
            this.get_options('countries', 'countries')
            this.get_options('customers', 'customers')
        },

        // ================== validation rule for form ==================
        validators: {
            "data.name": function (value = null) {
                return Validator.value(value).required("Name is required");
            },
            "data.email": function (value = null) {
                return Validator.value(value).required("Email is required");
            },
            "data.mobile": function (value = null) {
                return Validator.value(value).required("Mobile is required");
            },
            "data.address": function (value = null) {
                return Validator.value(value).required("Address is required");
            },
            "data.country_id": function (value = null) {
                return Validator.value(value).required("Country is required");
            },
            "data.city_id": function (value = null) {
                return Validator.value(value).required("City is required");
            },
        },
    };
</script>
