<template>

    <div class="page-content">
                <div class="container-fluid">
                    <div class="row justify-content-center" v-if="content && Object.keys(content).length > 0">
                        <div class="col-lg-10">
                            <div class="card">
                                <div class="bg-soft-warning position-relative">
                                    <div class="card-body p-5">
                                        <div class="text-center">
                                            <h3 v-if="content.title">{{content.title}}</h3>
                                            <p class="mb-0 text-muted">Last update: {{content.created_at}}</p>
                                        </div>
                                    </div>
                                    <div class="shape">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="1440" height="60" preserveAspectRatio="none" viewBox="0 0 1440 60">
                                            <g mask="url(&quot;#SvgjsMask1001&quot;)" fill="none">
                                                <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z" style="fill: var(--vz-card-bg-custom);"></path>
                                            </g>
                                            <defs>
                                                <mask id="SvgjsMask1001">
                                                    <rect width="1440" height="60" fill="#ffffff"></rect>
                                                </mask>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div>
                                        <div v-html="content.description">{{content.description}}</div>

                                    </div>
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
                <!-- container-fluid -->
    </div>
            <!-- End Page-content -->
</template>

<script>
    export default {
        name: "TermsPolicies",
        data(){
            return{
                content:[]
            }
        },
        watch:{
            $route:{
                handler(){
                    this.getPageContent();
                },
                deep:true,
                immediate:true,
            }
        },
        methods:{
            getPageContent(){
                axios.get('/get-page-content/'+this.$route.params.slug).then(res => {
                    this.content = res.data;
                }).catch(error => {
                    console.log(error);
                })
            }
        },
        created(){
            this.getPageContent();
        }
    }
</script>


