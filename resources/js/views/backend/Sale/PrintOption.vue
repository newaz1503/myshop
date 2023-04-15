<template>
    <div class="">
        <div class="modal-header d-flex gap-2 align-items-center">
            <div class="header-image">
                <img :src="$root.baseurl+'/admin/images/complete.gif'" alt="">
            </div>
            <div class="body">
                <h1>Your order has been placed successfully!</h1>
            </div>
        </div>
        <div class="pinter">
            <h4 class="text-center text-muted">Please select your printer and continue!</h4>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 position-relative">
                    <div class="card bg-dark text-white">
                        <img :src="$root.baseurl+'/admin/images/printer/a4printer.png'" alt="">
                        <div class="card-img-overlay">
                            <button class="btn btn-secondary btn-border">A4 Size Printer <i class="fa fa-print"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 position-relative">
                    <div class="card bg-dark text-white">
                        <img :src="$root.baseurl+'/admin/images/printer/thermal-printer.png'" alt="">
                        <div class="card-img-overlay">
                            <button class="btn btn-warning btn-border">Thermal Printer <i class="fa fa-print"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PrintOption"
    }
</script>

<style lang="scss">
    .pinter{
        .card-img-overlay {
            background: #2a313754;
            display: flex;
            justify-content: center;
            align-items: center;

        }
        .card{
            img{
                height: 325px;
            }
        }
    }
</style>
