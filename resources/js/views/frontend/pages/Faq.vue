<template>
    <section id="checkout_page" class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-header mb-4">
                            <h3>Frequently Asked Questions</h3>

                        </div>
                        <div class="card-body checkout-tab p-0">
                            <div class="accordion" id="accordionExample" v-if="faqs.length > 0">
                                <div v-for="(faq,index) in faqs" class="accordion-item" :key="index">
                                    <h2 class="accordion-header" id="headingOne">

                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="`#collapse${index}`" aria-expanded="true" aria-controls="collapseOne">
                                        {{faq.title}}
                                    </button>
                                    </h2>
                                    <div :id="`collapse${index}`" :class="index == 0 ? 'accordion-collapse collapse show' : 'accordion-collapse collapse'" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{{faq.details}}</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                             <div v-else class="row pt-3">
                                <div class="col-lg-12 bg-white" v-if="!is_loading">
                                    <div class="row justify-content-center py-5">
                                        <div class="col-lg-6 text-center">
                                            <img :src="$root.baseurl+'/public/frontend/images/not-found.jpg'" class="img-fluid rounded" alt="" width="220" height="120">
                                            <h5>Not Available!</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>

            </div>
        </div>

    </section>
</template>

<script>
    export default {
        name: "faq",
        data(){
            return{
                is_loading:false,
                faqs: []
            }
        },
        mounted(){
            this.getfaq()
        },
        methods:{
            getfaq(){
                axios.get('/faq')
                .then(res => {
                    this.faqs= res.data
                })
                .catch(e => {
                    console.log(e);
                })
            }
        }
    }

</script>

<style scoped>

.panel-title > a:before {
    float: right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 5px;
}
body{
  background-color:#f5f5f5;
}
.panel-title > a.collapsed:before {
    float: right !important;
    content:"\f067";
}
.panel-title > a:hover,
.panel-title > a:active,
.panel-title > a:focus  {
    text-decoration:none;
}
.panel-heading {
    padding: 20px 15px;
    border-bottom: 1px solid transparent;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}
.panel {
    margin-bottom: 20px !important;
    background-color: #ffffff;
    border: 1px solid transparent;
    -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
    box-shadow: 15px 16px 13px 8px rgb(4 4 4 / 5%);
}
.jumbotron {
    padding-top: 30px;
    padding-bottom: 30px;
    margin-bottom: 30px;
    color: inherit;
    background-color: #00bcd4;
    text-align: center;
    color: #fff;
}




</style>


