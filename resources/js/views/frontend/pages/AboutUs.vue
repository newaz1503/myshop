<template>
    <div class="container py-5">
        <div class="row" v-if="about && Object.keys(about).length > 0">
                <h1 class="text-center mb-4">About Us</h1>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 v-if="about.title">{{about.title}}</h4>
                        </div>
                        <div class="card-body">
                            <div v-html="about.description">{{about.description}}</div>
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
</template>

<script>
    export default {
        name: "AboutUs",
        data(){
            return{
                about: ''
            }
        },
        mounted(){
            this.getAllAbout();
        },
        methods:{
            getAllAbout(){
                axios.get('/about-us')
                .then(res => {
                    this.about = res.data;
                })
                .catch(e => {
                    console.log(e);
                })
            }
        }
    }
</script>


