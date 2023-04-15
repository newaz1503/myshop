<template>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <router-link :to="{name:'admin.dashboard'}" class="logo">
                            <h2 class="m-0 text-logo">{{ $root.settings.app_name }}</h2>
                        </router-link>
                    </div>

                    <button @click="sidebarChangeHandler" type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>

                    <a :href="$root.baseurl+'/'" target="_blank" class="btn-rounded btn btn-light btn-icon waves-effect mt-3 mx-4 header-item vertical-menu-btn topnav-hamburger">
                        <i class="bx bx-store"></i>
                    </a>
                    <a :href="$root.baseurl+'/clear'" target="_blank" class="btn-rounded btn btn-light btn-icon waves-effect mt-3 mx-4 header-item vertical-menu-btn topnav-hamburger">
                        <i class="mdi mdi-broom"></i>
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                               aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="topbar-head-dropdown ms-1 header-item">
                        <router-link :to="{name:'sale.create'}"
                                     class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                     id="page-header-cart-dropdown">
                            <i class='bx bx-shopping-bag fs-22'></i>
                            <span
                                class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-info">{{ $store.state.cartCount }}</span>
                        </router-link>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                @click="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" @click="changeMode"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>
                    <!-- Notifications -->

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" v-if="adminInfo"
                                 :src="adminInfo.profile" alt="">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    {{ adminName }}
                                </span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                    {{ adminRole }}
                                </span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header"></h6>
                            <router-link :to="{name:'admin.show',params:{id:adminId}}" class="dropdown-item" ><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></router-link>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" @click="Logout()" href="javascript:void(0);">
                                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

</template>

<script>
    export default {
        name: "HeaderComponent",
        data(){
            return{
                is_fullscreen:false,
                adminInfo: {},
            }
        },
        computed:{
            adminId(){
                return Admin.id()
            },
            adminName(){
                return Admin.name()
            },
            adminRole(){
                return Admin.role()
            },

        },
        methods: {
            getAdminInfo(){
                axios.get('admin/'+this.adminId)
                  .then(response=>{
                        this.adminInfo = response.data
                    })
                  .catch(error=>{
                        console.log(error)
                    })
            },
            fullscreen() {
                if (!this.is_fullscreen){
                    var elem = document.documentElement;
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                }else{
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }
                this.is_fullscreen = !this.is_fullscreen;
            },
            changeMode() {
                let htmlElement = document.querySelector('html');
                if (htmlElement.getAttribute('data-layout-mode') == 'dark'){
                    htmlElement.setAttribute('data-layout-mode','light')
                    sessionStorage.setItem("data-layout-mode", "light");
                }else{
                    htmlElement.setAttribute("data-layout-mode","dark")
                    sessionStorage.setItem("data-layout-mode", "dark");
                }
            },
            sidebarChangeHandler(){
                let htmlElement = document.querySelector('html');
                if (htmlElement.getAttribute('data-sidebar-size') == 'sm'){
                    htmlElement.setAttribute('data-sidebar-size','lg')
                    sessionStorage.setItem("data-sidebar-size", "lg");
                }else{
                    htmlElement.setAttribute("data-sidebar-size","sm");
                    sessionStorage.setItem("data-sidebar-size", "sm");
                }
            },
            Logout() {
                this.$root.spinner = true;
                Admin.logout();
            }
        },
        created() {
            this.getAdminInfo();
        }
    }
</script>

<style scoped>

</style>
