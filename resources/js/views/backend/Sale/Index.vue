<template>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3  justify-content-end">
                <div class="col-lg-12">
                    <form v-on:submit.prevent="search">
                        <div class="row  align-items-center">
                            <div class="col">
                                <label for="">From Date</label>
                                <input type="date" v-model="search_data.from_date" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">To Date</label>
                                <input type="date" v-model="search_data.to_date" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Select Customer</label>
                                <v-select
                                    :options="options.customers"
                                    :reduce="customer => customer.id"
                                    label="name"
                                    v-model="search_data.customer_id"
                                />
                            </div>
                            <div class="col">
                                <label for="">Invoice Id</label>
                                <input type="text" v-model="search_data.invoice_id" class="form-control">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-border mt-4">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="data-table">
                <base-table
                    :data="table.datas"
                    :columns="table.columns"
                    :routes="table.routes"
                    thead-classes="bg-light text-secondary"
                ></base-table>
                <Pagination
                    :url="model"
                    v-if="!$root.spinner"
                    :search_data="search_data"
                />
            </div>
        </div>
    </div>
</template>

<script>
    // define model name
    const model = "sale";

    // define table coloumn show in datatable / datalist
    const tableColumns = [
        { field: "invoice_id", title: "Invoice Id" },
        { field: "customer", title: "Customer", subfield:'name' },
        { field: "total_quantity", title: "Total Quantity" },
        { field: "sub_total", title: "Sub Total" },
        { field: "invoice_discount", title: "Inv. Disc" },
        { field: "product_discount", title: "Prod. Disc" },
        { field: "shipping_cost", title: "Shipping Cost" },
        { field: "grand_total", title: "Total Amount" },
        { field: "created_at", title: "Created at",date:true }
    ];
    //json fields for export excel
    const json_fields = {
        Title: "title",
        "Created at": "created_at"
    };

    export default {
        data() {
            return {
                model: model,
                json_fields: json_fields,
                fields_name: { 0: "Select One", title: "Title" },
                search_data: {
                    pagination: 10,
                    field_name: 0,
                    value: "",
                    customer_id:'',
                    invoice_id:''
                },
                table: {
                    columns: tableColumns,
                    routes: {},
                    datas: [],
                    meta: [],
                    links: []
                },
                options: {
                    customers: [],
                },
            };
        },
        methods: {
            destroy(id) {
                this.destroy_data(this.model, id, this.search_data);
            },
            search() {
                this.$route.query.page = "";
                this.get_paginate_data(this.model, this.search_data);
            }
        },
        async created() {
            await this.get_paginate_data(this.model, this.search_data);
            this.getRouteName(this.model);
            this.setBreadcrumbs(this.model, "index");
            this.get_options('customers', 'customers')
        }
    };
</script>
