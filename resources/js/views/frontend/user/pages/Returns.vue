<template>
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header  border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Order History</h5>
                    <div class="flex-shrink-0">

                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form>
                    <div class="row g-3 align-items-center">
                        <div class="col-xxl-4 col-sm-4">
                            <div class="search-box mt-4">
                                <input type="text" class="form-control search" placeholder="Search for order ID, customer, order status or something...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-sm-3">
                            <div>
                                <label for="">From Date</label>
                                <input type="date" name="from_date" class="form-control"  placeholder="Select date">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-3">
                            <div>
                                <label for="">To Date</label>
                                <input type="date" name="to_date" class="form-control"  placeholder="Select date">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-2">
                            <div class="mt-4">
                                <button type="button" class="btn bg-color text-white w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    Filters
                                </button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="card-body pt-0">
                <div>
                    <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link All py-3  active" href="#home1">
                                <i class="ri-store-2-fill me-1 align-bottom"></i> All Orders
                            </a>
                        </li>

                    </ul>

                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="orderTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Order Date</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Delivery Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            <tr>
                                <td class="id"><a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2101</a></td>
                                <td class="product_name">Puma Tshirt</td>
                                <td class="date">20 Dec, 2021, <small class="text-muted">02:21 AM</small></td>
                                <td class="amount">$654</td>
                                <td class="payment">Mastercard</td>
                                <td class="status"><span class="badge badge-soft-warning text-uppercase">Pending</span>
                                </td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="View" data-bs-original-title="View">
                                            <a href="apps-ecommerce-order-details.html" class="text-primary d-inline-block">
                                                <i class="ri-eye-fill fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a order ?</h4>
                                    <p class="text-muted fs-15 mb-4">Deleting your order will remove all of your information from our database.</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <button class="btn btn-danger" id="delete-record">Yes, Delete It</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal -->
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Orders"
    }
</script>

<style scoped>

</style>
