<template>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3 justify-content-end">
                <div class="col-lg-2 text-end order-last offset-2">
                    <!-- ============ Add or Back Button Start ============ -->
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
                    <Select
                        v-if="couponType"
                        title="Coupon type"
                        field="coupon_type"
                        :req="true"
                        :datas="couponType"
                    />
                    <!------------ Single Input ------------>
                    <Input title="Title" field="title" :req="true"/>
                    <Input title="Code" field="code" :req="true"/>
                    <!------------ Single Input ------------>
                    <Select
                        v-if="discount_types"
                        title="Discount types"
                        field="discount_type"
                        :req="true"
                        :datas="discount_types"
                    />
                    <Input title="Discount Amount" field="discount_amount"  :req="true"/>
                    <template v-if="data.coupon_type == 'for_total_orders'">
                        <Input title="Minimum Order Amount"  field="minimum_order_amount" :req="false"/>
                    </template>
                    <!------------ Single Select (using pluck) ------------>
                    <Input title="Expire Date" type="date" field="expire_date" :req="true"/>
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
                    <div class="mb-3" v-if="data.coupon_type == 'for_products'">
                        <label for="" class="form-label d-block ">Products *</label>
                        <b-form-group
                            class="w-100 similar-product-selector"
                            label-for="tags-with-dropdown"
                        >
                            <b-form-tags
                                id="tags-with-dropdown"
                                no-outer-focus
                                class="mb-2"
                            >
                                <template v-slot="{ disabled }">
                                    <b-dropdown
                                        size="sm"
                                        variant="outline-light"
                                        block
                                        menu-class="w-100 text-start"
                                    >
                                        <template #button-content>Select Product</template>
                                        <b-dropdown-form @submit.stop.prevent="() => {}">
                                            <b-form-group
                                                label="Search product"
                                                label-for="tag-search-input"
                                                label-cols-md="auto"
                                                class="mb-0"
                                                label-size="sm"
                                                :description="searchDesc"
                                                :disabled="disabled"
                                                placeholder="type your product name"
                                            >
                                                <b-form-input
                                                    v-model="search"
                                                    id="tag-search-input"
                                                    type="search"
                                                    size="sm"
                                                    autocomplete="off"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-dropdown-form>
                                        <b-dropdown-item-button
                                            v-for="(option, index) in availableOptions"
                                            :key="index"
                                            @click="selectedProduct(option,'section_one_products')"
                                        >
                                            <div class="d-flex align-items-center">
                                                <img
                                                    class="mr-2"
                                                    height="45"
                                                    :src="option.featured_image"
                                                    alt
                                                />
                                                <span>{{ option.name }}</span>
                                            </div>
                                        </b-dropdown-item-button>
                                        <b-dropdown-text v-if="availableOptions.length === 0">
                                            There are no product available to select
                                        </b-dropdown-text>
                                    </b-dropdown>
                                    <ul
                                        v-if="data.products.length > 0"
                                        class="list-inline d-inline-block mb-2 selected-product"
                                    >
                                        <li
                                            v-for="(product, index) in data.products"
                                            :key="index"
                                            class="list-inline-item"
                                        >
                                            <b-form-tag
                                                @remove="removeSelectedProduct(index)"
                                                :title="product.name"
                                                variant="light"
                                            >
                                                <div class="d-flex">
                                                    <img height="30" :src="product.featured_image" alt/>
                                                    <div class="text-start">
                                                        <h6 class="m-0">
                                                            {{ product.name }}
                                                        </h6>
                                                        <span class="text-red">
                                                                              BDT {{ product.sale_price }}
                                                                            </span>
                                                    </div>
                                                </div>
                                            </b-form-tag>
                                        </li>
                                    </ul>
                                </template>
                            </b-form-tags>
                        </b-form-group>
                    </div>
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
    const model = "coupon";

    export default {
        data() {
            return {
                model: model,
                data: {
                    products: [],
                    coupon_type: '',
                    discount_type: '',
                    status: 'active',
                },
                discount_types: {
                    percentage: "Percentage",
                    amount: "Amount",
                },
                couponType: {
                    for_products: "For Products",
                    for_total_orders: "For Total Orders",
                },
                categories: [],
                products: [],
                search: "",
            };
        },
        computed: {
            criteria() {
                return this.search.trim().toLowerCase();
            },
            availableOptions() {
                const options = this.products.filter(
                    (opt) => this.data.products.indexOf(opt) === -1
                );
                if (this.criteria) {
                    return options.filter(
                        (product) => product.name.toLowerCase().indexOf(this.criteria) > -1
                    );
                }
                return options;
            },
            searchDesc() {
                if (this.criteria) {
                    return "There are no product matching your search criteria";
                }
                return "";
            },
        },
        methods: {
            selectedProduct(product) {
                this.data.products.push(product);
                this.search = "";
            },
            removeSelectedProduct(product) {
                this.data.products.splice(product, 1);
            },
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
            axios.get('product-list').then(res => this.products = res.data);
        },

        // ================== validation rule for form ==================
        validators: {
            "data.title": function (value = null) {
                return Validator.value(value).required("Title is required");
            },
            "data.coupon_type": function (value = null) {
                return Validator.value(value).required("Coupon Type is required");
            },
            "data.code": function (value = null) {
                return Validator.value(value).required("Code is required");
            },
            "data.discount_type": function (value = null) {
                return Validator.value(value).required("Discount Type is required");
            },
            "data.discount_amount": function (value = null) {
                return Validator.value(value).required("Discount Amount is required");
            },
            "data.status": function (value = null) {
                return Validator.value(value).required("Status is required");
            },
            "data.expire_date": function (value = null) {
                return Validator.value(value).required("Expire Date is required");
            },
        },
    };
</script>

<style lang="scss">
    li.list-inline-item {
        background: #ffffff;
        margin: 4px;
        width: 150px;
        box-shadow: 0 0px 2px #4444;
        span.badge.b-form-tag {
            color: #6a6262;
            justify-content: space-around;
            align-items: center;
            font-size: 12px;
        }
        img.tag-image {
            height: 20px;
            width: 20px;
            border-radius: 5px;
        }
        button.close.b-form-tag-remove {
            padding: 2px 4px;
            border: 0;
            background: red;
            color: #fff;
            display: block;
            border-radius: 3px;
        }
    }
    .similar-product-selector {
        div#tags-with-dropdown {
            padding: 0;
            border: 0;
        }
        button.btn-outline-light {
            text-align: left;
            display: block;
            width: 100%;
            padding: 0.5rem 0.9rem;
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--vz-body-color);
            background-color: var(--vz-input-bg);
            background-clip: padding-box;
            border: 1px solid var(--vz-input-border);
        }
        ul.dropdown-menu {
            box-shadow: 0px 4px 6px #4444;
            padding: 10px;
            border: 1px solid #3f51b5 !important;
            max-height: 298px !important;
            overflow-y: auto;
            transform: translate3d(0px, 38px, 0px)!important;
        }
        ul.selected-product {
            margin-top: 5px;
            margin-bottom: 0 !important;
            li {
                padding: 4px;
            }
        }
        button.close.b-form-tag-remove {
            color: #fff !important;
        }
        button.dropdown-item {
            color: #000 !important;
            white-space: normal;
        }
    }

</style>
