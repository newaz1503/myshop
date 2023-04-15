<template>
    <div>
        <div class="mb-4">
                <div class="">
                    <div class="row justify-content-end">
                        <div class="col-lg-2 text-end order-last offset-2">
                            <!--============ Add or Back Button Start ============-->
                            <AddOrBackButton
                                :route="model + '.index'"
                                :portion="model"
                                :icon="'arrow-left'"
                            />
                        </div>
                    </div>
                    <div class="view-table">


                        <!--============ View Base Table Start ============-->
                            <!-- <ViewBaseTable :data="data" /> -->
                            <!--============ View Base Table End ============-->
                    </div>
                </div>
        </div>

        <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 gap-2">
                <div class="card">
                    <div class="card-header"><h5>Customer Info</h5></div>
                    <div class="card-body">
                        <div class="user_info">
                            <table>
                                <tr>
                                    <td>Invocie #</td>
                                    <td>:</td>
                                    <td>{{ data.invoice_id }}</td>
                                </tr>
                                <tr>
                                    <td>Sold To</td>
                                    <td>:</td>
                                    <td>{{ data.customer ? data.customer.name : 'N/L' }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>
                                        <address class="mb-0">
                                            {{ data.customer ? data.customer.address : 'N/L'}}
                                        </address>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sales Per.</td>
                                    <td>:</td>
                                    <td>Admin</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header"><h5>Invoice Info</h5></div>
                    <div class="card-body">
                        <div class="invoice_info">
                            <A4Printer :invoice="data" v-if="Object.keys(data).length > 0"></A4Printer>

                        </div>
                    </div>

                </div>
            </div>
        </div>


        </div>
</template>

<script>
// define model name
const model = "sale";
import A4Printer from "./A4Printer";
export default {
    components: {A4Printer},
  data() {
    return {
      model: model,
      data: []
    };
  },
  async created() {
    await this.get_data(this.model, this.$route.params.id, "data"); // get data
    this.setBreadcrumbs(this.model, "view"); // Set Breadcrumbs
  }
};
</script>
