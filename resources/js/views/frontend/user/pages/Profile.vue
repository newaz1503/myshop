<template>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Change Profile Information</h5>
            </div>
            <div class="card-body">
                <form @submit.prevent="updateProfileInfo" enctype="multipart/form-data" id="userInfoForm">
                    <div class="row">
                        <div class="col-lg-7">
                            <Input
                                title="Full Name"
                                field="name"
                                col="12"
                                type="text"
                                :req="true"
                            />
                            <Input
                                title="Phone Number"
                                field="mobile"
                                col="12"
                                type="text"
                                :req="true"
                            />
                            <Input
                                title="Email Address"
                                field="email"
                                col="12"
                                type="email"
                                :req="true"
                            />
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-border">Update Profile</button>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center ms-3">
                            <div class="card card-body">
                                <div class="profile-prevew-image">
                                    <img v-if="data.avatar" :src="data.avatar" alt="">
                                    <img v-else :src="$root.noimage" alt="">
                                </div>
                                <div class="image-sector image-sector text-center mt-4">
                                    <input
                                        type="file"
                                        accept="image/png, image/jpg, image/jpeg"
                                        name="avatar"
                                        id="avatar"
                                        @change="imageHandler($event)"
                                        class="avatar mb-2 d-none"
                                    >
                                    <label for="avatar" class="btn btn-sm btn-light px-5">
                                        Choose File
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h5 class="card-title">Billing & Shipping Address</h5>
                <b-button class="btn btn-border btn-primary mb-3"
                          v-b-modal="'shipping-form-modal'">Add Address
                </b-button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h6 class="mb-3">Default Shipping Address</h6>
                        <div class="address-box border border-dashed p-3" v-if="defaultShippingAddress">
                            <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                {{ defaultShippingAddress.address }},
                                {{ defaultShippingAddress.country? defaultShippingAddress.country.name : '' }},
                                {{ defaultShippingAddress.state? defaultShippingAddress.state.name: '' }},
                                {{ defaultShippingAddress.city? defaultShippingAddress.city.name: '' }}
                            </span>
                            <span class="text-muted fw-normal d-block">Phone. {{ defaultShippingAddress.mobile }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h6 class="mb-3">Default Billing Address</h6>
                        <div class="address-box border border-dashed p-3" v-if="defaultBillingAddress">
                            <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                {{ defaultBillingAddress.address }},
                                {{ defaultBillingAddress.country? defaultBillingAddress.country.name : '' }},
                                {{ defaultBillingAddress.state? defaultBillingAddress.state.name: '' }},
                                {{ defaultBillingAddress.city? defaultBillingAddress.city.name: '' }}
                            </span>
                            <span class="text-muted fw-normal d-block">Phone. {{ defaultBillingAddress.mobile }}</span>
                        </div>
                    </div>
                </div>
                <div class="row gy-3 mt-3">
                    <template
                        v-if="data.shippingAddress && Object.keys(data.shippingAddress).length > 0">
                        <div class="col-lg-4 col-sm-6"
                             v-for="(address,key) in  data.shippingAddress" :key="key">
                            <div class="border border-dashed p-2">
                                <div class="fw-semibold d-flex align-content-center justify-content-between position-relative">
                                    {{ address.shipping_type}}
                                    <div class="dropstart">
                                        <a href="javascript:" class="fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item text-dark" @click.prevent="editShippingInfo(address)" href="javascript:void(0);">
                                                    <i class="ri-pencil-fill  align-bottom me-1"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-primary" href="javascript:void(0);" @click="makeDefault(address.id,'default_shipping')">
                                                    <i class="mdi mdi-pin-outline me-2 align-bottom"></i>Make default shipping
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-secondary" href="javascript:void(0);" @click="makeDefault(address.id,'default_billing')">
                                                    <i class="mdi mdi-pin-outline me-2 align-bottom"></i>Make default billing
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" @click="revomeShippingInfo(address.id)" href="javascript:void(0);">
                                                    <i class="mdi mdi-trash-can align-bottom me-1"></i>Remove
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="fs-14 mb-2 d-block">0{{ key+1 }}</span>
                                <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                    {{ address.address }},
                                    {{ address.country? address.country.name : '' }},
                                    {{ address.state? address.state.name: '' }},
                                    {{ address.city? address.city.name: '' }}
                                </span>
                                <span class="text-muted fw-normal d-block">Phone. {{ address.mobile }}</span>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="text-center">
                            <h4 class="text-danger my-5">You don't have any shipping
                                address!</h4>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <b-modal id="shipping-form-modal" hide-footer title="Add Shipping Info">
            <form @submit.prevent="addShipping">
                <div class="form-group col-12" :class="{
                                'has-error': errorField.address,
                                'has-success': errorField.address,
                              }">
                    <label class="control-label">Address</label>
                    <textarea
                        name="address"
                        placeholder="Address"
                        v-model="shippingAddressData.address"
                        class="form-control form-control-sm">
                    </textarea>
                    <span class="help-block">
                        {{ errorField.address }}
                    </span>
                </div>
                <div class="col-12 form-group" :class="{
                                'has-error': errorField.country_id,
                                'has-success': errorField.country_id,
                              }">
                    <label for="">Select Country</label>
                    <v-select
                        :options="options.countries"
                        :reduce="country => country.country_id"
                        label="name"
                        v-model="shippingAddressData.country_id"
                    />
                    <span class="help-block">
                            {{ errorField.country_id }}
                          </span>
                </div>
                <div class="col-12 form-group" :class="{
                            'has-error': errorField.state_id,
                            'has-success': errorField.state_id,
                          }">
                    <label for="">Select State</label>
                    <v-select
                        :options="options.states"
                        :reduce="state => state.state_id"
                        label="name"
                        v-model="shippingAddressData.state_id"
                    />
                    <span class="help-block">
                            {{ errorField.state_id }}
                          </span>
                </div>
                <div class="col-12 form-group" :class="{
                                'has-error': errorField.city_id,
                                'has-success': errorField.city_id,
                              }">
                    <label for="">Select City</label>
                    <v-select
                        :options="options.cities"
                        :reduce="city => city.id"
                        label="name"
                        v-model="shippingAddressData.city_id"
                    />
                    <span class="help-block">
                            {{ errorField.city_id }}
                          </span>
                </div>
                <div class="form-group col-12 " :class="{
                                'has-error': errorField.postal_code,
                                'has-success': errorField.postal_code,
                              }">
                    <label class="">Postal Code</label>
                    <input
                        name="postal_code"
                        placeholder="Postal Code"
                        type="number"
                        class="form-control"
                        v-model="shippingAddressData.postal_code"
                    >
                    <span class="help-block">
                        {{ errorField.postal_code }}
                    </span>
                </div>
                <div class="form-group col-12 " :class="{
                                'has-error': errorField.mobile,
                                'has-success': errorField.mobile,
                              }">
                    <label class="control-label">Mobile</label>
                    <input
                        name="mobile"
                        placeholder="Mobile"
                        type="number"
                        class="form-control"
                        v-model="shippingAddressData.mobile"
                    >
                    <span class="help-block">
                        {{ errorField.mobile }}
                    </span>
                </div>
                <div class="form-group col-12 mt-4">
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-radio-primary mb-3">
                                <input
                                    v-model="shippingAddressData.shipping_type"
                                    class="form-check-input"
                                    type="radio"
                                    name="shipping_type"
                                    id="homeAddress"
                                    value="Home Address"
                                >
                                <label class="form-check-label" for="homeAddress">
                                    Home Address
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-radio-primary mb-3">
                                <input
                                    v-model="shippingAddressData.shipping_type"
                                    class="form-check-input"
                                    type="radio"
                                    name="shipping_type"
                                    id="officeAddress"
                                    value="Office Address"
                                >
                                <label class="form-check-label" for="officeAddress">
                                    Office Address
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------- button -------------->
                <div class="col-12 mb-3 mt-4 text-end">
                    <button @click="$bvModal.hide('shipping-form-modal')" type="button"
                            class="btn btn-danger btn-border px-4">
                        <span> Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-border btn-primary px-4">
                        <span> Submit</span>
                    </button>
                </div>
            </form>
        </b-modal>
    </div>

</template>

<script>
    export default {
        name: "Profile",
        data() {
            return {
                data: {
                    avatar: '',
                    name: '',
                    mobile: '',
                    email: '',
                },
                shippingAddressData: {
                    address: '',
                    country_id: '',
                    state_id: '',
                    city_id: '',
                    postal_code: '',
                    mobile: '',
                },
                defaultShippingAddress: {
                    country_id: '',
                    state_id: '',
                    city_id: '',
                    postal_code: '',
                    address: '',
                },
                defaultBillingAddress: {
                    country_id: '',
                    state_id: '',
                    city_id: '',
                    postal_code: '',
                    address: '',
                },
                shippingAddress: [],
                image: {
                    avatar: '',
                },
                form: {},
                profileInfo: [],
                options: {
                    countries: [],
                    states: [],
                    cities: [],
                },
                errorField:{
                    country_id: '',
                    state_id: '',
                    city_id: '',
                    address: '',
                    mobile: '',
                }
            }
        },
        watch: {
            'shippingAddressData.country_id'(countryId) {
                this.getStates(countryId);
                this.getCities(countryId);
            },
            'shippingAddressData.state_id'(stateId) {
                this.getCities(this.shippingAddressData.country_id, stateId);
            },
        },
        mounted() {
            // Get User Details
            axios.get('user/profile-info').then((res) => {
                this.data = res.data.profileInfo;
                this.data.shippingAddress = res.data.shippingInfo;
                this.defaultShippingAddress = res.data.defaultShipping;
                this.defaultBillingAddress = res.data.defaultBilling;
            }).catch((error) => {
                console.log(error)
            })
        },
        methods: {
            updateProfileInfo() {
                this.$validate().then((res) => {
                    const error = this.validation.countErrors();
                    if (error > 0) {
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "warning"
                        );
                        return false;
                    }
                    if (res) {
                        let form = document.getElementById("userInfoForm");
                        let formData = new FormData(form);
                        axios.post('/user/profileUpdate', formData).then((response) => {
                            this.notification('Profile update successful', 'success');
                            window.location.reload();
                        }).catch((error) => {
                            console.log(error)
                        })
                    }
                });
            },
            addShipping(){
                this.checkValidity('address');
                this.checkValidity('country_id');
                this.checkValidity('state_id');
                this.checkValidity('city_id');
                this.checkValidity('mobile');

                if (!this.checkValidity('address')){
                    return false;
                }
                if (!this.checkValidity('country_id')){
                    return false;
                }
                if (!this.checkValidity('state_id')){
                    return false;
                }
                if (!this.checkValidity('city_id')){
                    return false;
                }
                if (!this.checkValidity('mobile')){
                    return false;
                }
                this.shippingAddressData['user_type'] = 'online';
                let url = 'shipping/store';
                if (this.shippingAddressData.id) {
                    url = 'shipping/update/' + this.shippingAddressData.id;
                }
                axios.post(url, this.shippingAddressData).then(res => {
                    this.$bvModal.hide('shipping-form-modal');
                    this.shippingAddressData = [];
                    this.notification(res.data.message, "success");
                    window.location.reload();
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.notification(error.response.data.message, "danger");
                    }
                })
            },
            editShippingInfo(address) {
                this.shippingAddressData = address;
                this.$bvModal.show('shipping-form-modal');

            },
            revomeShippingInfo(shippingId) {
                this.$swal.fire({
                    title: 'Are you sure to remove this item?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('shipping-info/destroy', {shipping_id: shippingId}).then(res => {
                            this.notification(res.data.message, "success");
                            window.location.reload();
                        }).catch(error => {
                            console.log(error)
                        })
                        this.$swal.fire('Successfuly Removed!', '', 'success')
                    }
                })
            },
            imageHandler(e) {
                this.image.avatar = e.target.files[0];
                this.data.avatar = URL.createObjectURL(e.target.files[0]);
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
            makeDefault(addressId,params) {
                let data = {
                    address_id: addressId,
                    default_data: params,
                }
                axios.post('user/shippingInfo/makeDefault', data).then(res => {
                    this.notification(res.data.message, "success");
                    window.location.reload();
                })
            },
            checkValidity(field){
                if(this.shippingAddressData[field] == ''){
                    this.errorField[field] = 'This field is required';
                    return false;
                }else {
                    this.errorField[field] = null;
                    return true;
                }
            }
        },

        created() {
            this.get_options('countries', 'countries');
        },
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
        },
    };
</script>
<style lang="scss">
    .profile-prevew-image {
        height: 130px;
        width: 130px;
        margin: 0 auto;
        border-radius: 50%;
        margin-bottom: 9px;
        padding: 0px;
        outline: 14px solid #9393930f;
        overflow: hidden;

        img {
            height: 100%;
            width: 100%;
            border-radius: inherit;
        }
    }

    .has-error span.help-block {
        color: red;
    }
    .form-group {
        min-height: 70px;
    }
</style>
