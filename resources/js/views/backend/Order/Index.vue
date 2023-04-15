<template>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3 justify-content-start">
                <div class="col-lg-3">
                    <select name="order_status" v-model="search_data.order_status" class="form-select form-select-sm">
                        <option value="">--Select One--</option>
                        <option value="pending">Pending</option>
                        <option value="placed_order">Placed Order</option>
                        <option value="approved">Approved</option>
                        <option value="cancel">Cancel</option>
                        <option value="delivered">Delivered</option>
                        <option value="hold">Hold</option>
                    </select>
                </div>
                <div class="col-lg-9">
                    <form v-on:submit.prevent="search">
                        <!--============ Search Option Start ============-->
                        <Search :fields_name="fields_name"/>
                        <!--============ Search Option End ============-->
                    </form>
                </div>
            </div>
            <div class="data-table">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="dataTables_length" id="selection-datatable_length">
                            <label class="form-label d-flex align-items-center">
                                <span>Show</span>
                                <select
                                    @change="search"
                                    v-model="search_data.pagination"
                                    class="form-select form-select-sm mx-2"
                                >
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>200</option>
                                    <option>500</option>
                                    <option value="9999">All</option>
                                </select>
                                <span>entries</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 text-end">
                        <button
                            type="button"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Print"
                            class="btn btn-outline-primary btn-sm"
                            @click="print('printArea', model)"
                        >
                            <i class="mdi mdi-printer "></i> Print
                        </button>


                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Download PDF"
                            @click="generatePdf"
                        >
                            <i class="mdi mdi-file-pdf-box "></i>PDF
                        </button>
                        <download-excel
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Export as Excel"
                            v-if="table.datas"
                            class="btn btn-outline-success btn-sm"
                            :data="table.datas"
                            :fields="json_fields"
                            :name="model + '.xls'"
                        >
                            <i class="mdi mdi-file-excel"></i>Excel
                        </download-excel>
                    </div>
                </div>
                <div id="printArea" class="col-12 no-padding">
                    <div class="table-responsive b-table-sticky-header">
                        <table id="pdf-table" class="table nowrap row-border order-column w-100">
                            <thead class="base-table-thead bg-purple text-white">
                            <tr>
                                <th class="sl text-dark text-center">#</th>
                                <th class="sort-th">Invoice Id</th>
                                <th class="sort-th">Customer</th>
                                <th class="sort-th">Payment Status</th>
                                <th class="sort-th">Order Status</th>
                                <th class="sort-th">Qty</th>
                                <th class="sort-th">Sub Total</th>
                                <th class="sort-th">Grand Total</th>
                                <th class="sort-th">Date</th>
                                <th width="5%" class="action">
                                    <i class="fa fa-cog text-dark" aria-hidden="true"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="table.datas && Object.keys(table.datas).length > 0">
                            <tr v-for="(data,index) in table.datas" :key="index"
                                class="change_sorting change_sortingundefined update_item1">
                                <td class="text-center">
                                    {{ index+1 }}
                                </td>
                                <td><span>{{ data.invoice_id }}</span></td>
                                <td><span>{{ data.customer ?  data.customer.name : ''}}</span></td>
                                <td>
                                    <span class="badge text-uppercase "
                                          :class="data.payment_status == 'paid' ? 'badge-soft-success':'badge-soft-danger'">
                                        {{ data.payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge text-uppercase badge-soft-danger">
                                        {{ data.order_status }}
                                    </span>
                                </td>
                                <td class="text-center"><span>{{ data.total_quantity }}</span></td>
                                <td class="text-center">
                                    <span class="badge text-bg-primary">
                                        {{ data.sub_total }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge text-bg-primary">
                                        {{ data.grand_total }}
                                    </span>
                                </td>
                                <td><span>{{ data.updated_at | formatDate }}</span></td>
                                <td class="action" style="">
                                    <div class="btn-group dropleft">
                                        <a href="javascript:void(0)"
                                           title="Click to more option"
                                           data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false" class="more-menu"><i
                                            class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <router-link :to="{name:'order.show',params:{id:data.id }}" class="action-view dropdown-item"
                                               title="View">
                                                <i class="fa fa-book-open text-success me-2" aria-hidden="true"></i>
                                                View
                                            </router-link>
<!--                                            <a href="/myshop/admin/order/1/edit" class="action-pencil dropdown-item"-->
<!--                                               title="Edit">-->
<!--                                                <i class="fa fa-pencil text-primary me-2"-->
<!--                                                   aria-hidden="true"></i>-->
<!--                                                Edit-->
<!--                                            </a>-->
<!--                                            <button title="Delete" class="action-trash dropdown-item me-2"><i-->
<!--                                                class="fa fa-trash text-danger" aria-hidden="true"></i> Delete-->
<!--                                            </button>-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    const model = "order";

    // define table coloumn show in datatable / datalist
    const tableColumns = [
        {field: "invoice_id", title: "invoice_id"},
        {field: "customer", title: "Customer", subfield: 'name'},
        {field: "order_status", title: "Order Status"},
        {field: "payment_method", title: "Payment Method"},
        {field: "payment_status", title: "Payment Status"},
        {field: "total_quantity", title: "Qty"},
        {field: "sub_total", title: "Sub Total"},
        {field: "grand_total", title: "Grand Total"},
        {field: "created_at", title: "Date", date: true}
    ];
    //json fields for export excel
    const json_fields = {
        invoice_id: "invoice_id",
        customer: "customer.name",
        order_status: "order_status",
        payment_method: "payment_method",
        payment_status: "payment_status",
        total_quantity: "total_quantity",
        sub_total: "sub_total",
        grand_total: "grand_total",
        created_at: "created_at",
    };

    export default {
        data() {
            return {
                model: model,
                json_fields: json_fields,
                fields_name: {
                    0: "Select One",
                    invoice_id: "Invoice Id",
                    order_status: "Order Status",
                    payment_status: "Payment Status",
                },
                search_data: {
                    pagination: 10,
                    field_name: 0,
                    value: "",
                    order_status: ""
                },
                table: {
                    columns: tableColumns,
                    routes: {},
                    datas: [],
                    meta: [],
                    links: []
                }
            };
        },
        methods: {
            destroy(id) {
                this.destroy_data(this.model, id, this.search_data);
            },
            search() {
                this.$route.query.page = "";
                this.get_paginate_data(this.model, this.search_data);
            },
            generatePdf() {
                const doc = new jsPDF();
                $(".action").css("display", "none");
                autoTable(doc, {html: "#pdf-table"});
                doc.save(this.$parent.model + ".pdf");
                setTimeout(() => $(".action").show(), 300);
            },
        },
        async created() {
            await this.get_paginate_data(this.model, this.search_data);
            this.getRouteName(this.model);
            this.setBreadcrumbs(this.model, "index");
        }
    };
</script>
<style scoped>
    th.sort-th {
        color: #444;
    }

    .dropdown-menu {
        box-shadow: rgba(68, 68, 68, 0.1) 0px 0px 20px 10px !important;
    }
    .data-table .table-responsive {
        min-height: 300px;
    }
</style>
