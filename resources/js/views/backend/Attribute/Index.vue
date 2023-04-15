<template>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3  justify-content-end">
                <div class="col-lg-8">
                    <form v-on:submit.prevent="search">
                        <!--============ Search Option Start ============-->
                        <Search :fields_name="fields_name"/>
                        <!--============ Search Option End ============-->
                    </form>
                </div>
                <div class="col-lg-2 text-end order-last offset-2">
                    <!--============ Add or Back Button Start ============-->
                    <AddOrBackButton
                        :route="model + '.create'"
                        :portion="model"
                        :icon="'plus'"
                    />
                    <!--============ Add or Back Button End ============-->
                </div>

            </div>
            <div class="data-table">
                <div id="printArea" class="col-12 no-padding">
                    <div class="table-responsive b-table-sticky-header">
                        <table id="pdf-table" class="table nowrap row-border order-column w-100">
                            <thead class="base-table-thead">
                            <tr>
                                <th class="sl text-center">#</th>
                                <th class="sort-th">Name</th>
                                <th class="sort-th">Values</th>
                                <th class="sort-th">Status</th>
                                <th class="sort-th">Sorting</th>
                                <th width="5%" class="action"><i class="fa fa-cog" aria-hidden="true"></i></th>
                            </tr>
                            </thead>
                            <tbody v-if="table.datas && Object.keys(table.datas).length > 0">
                            <tr v-for="(data,index) in table.datas" :key="index"
                                class="change_sorting change_sorting1 update_item1">
                                <td class="text-center">
                                    {{ index+1 }}
                                </td>
                                <td><span>{{ data.name }}</span></td>
                                <td>
                                    <template v-for="(value,key) in data.values">
                                        <span :key="key" class="btn btn-light btn-sm mx-1">
                                            {{ value.value }}
                                        </span>
                                    </template>
                                </td>
                                <td>
                                    <span class="badge bg-success rounded-pill px-2 py-1 ">
                                        {{ data.status }}
                                    </span>
                                </td>
                                <td>
                                    {{ data.sorting }}
                                </td>
                                <td class="action">
                                    <div class="btn-group dropleft">
                                        <a href="javascript:void(0)"
                                           title="Click to more option"
                                           data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false" class="more-menu">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <router-link :to="{name:'attribute.show',params:{id: data.id }}"
                                                         class="action-view dropdown-item"
                                                         title="View">
                                                <i class="fa fa-book-open text-success me-2"
                                                   aria-hidden="true"></i> View
                                            </router-link>
                                            <router-link :to="{name:'attribute.edit',params:{id: data.id }}"
                                                         class="action-pencil dropdown-item" title="Edit"><i
                                                class="fa fa-pencil text-primary me-2" aria-hidden="true"></i> Edit
                                            </router-link>
                                            <button @click="destroy(data.id)" title="Delete"
                                                    class="action-trash dropdown-item me-2"><i
                                                class="fa fa-trash text-danger" aria-hidden="true"></i> Delete
                                            </button>
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
    const model = "attribute";

    // define table coloumn show in datatable / datalist
    const tableColumns = [
        {field: "name", title: "Name"},
        {field: "values", title: "Values"},
        {field: "status", title: "Status"},
        {field: "sorting", title: "Sorting"},
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
                fields_name: {0: "Select One", title: "Title"},
                search_data: {
                    pagination: 10,
                    field_name: 0,
                    value: ""
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
                if (confirm("Are you sure to delete this item")){
                    this.destroy_data(this.model, id, this.search_data);
                }
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
        }
    };
</script>
<style>
    .dropdown-menu {
        box-shadow: rgba(68, 68, 68, 0.1) 0px 0px 20px 10px;
    }
</style>
