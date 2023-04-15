<template>
    <div id="mobile_appbar" class="position-fixed bottom-0 start-50 translate-middle-x z-index-999 w-100 d-lg-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 ps-0 pe-0">
                    <svg id="appbar" width="0" height="0" viewBox="0 0 72 36" xmlns="http://www.w3.org/2000/svg">
                        <clipPath id="appbar__cutout">
                            <path d="M36 36C55.8823 36 72 19.8823 72 0V112H0V0C0 19.8823 16.1177 36 36 36Z" />
                        </clipPath>
                    </svg>
                    <div class="appbar appbar__bottom appbar__bottom--center-cut">
                        <a href="javacript:void(0)" class="appbar__bottom--fab appbar__bottom--fab-primary" title="add" aria-label="Add">
                            <i class="bx bx-home"></i>
                        </a>

                        <div class="appbar__bottom--normal">
                            <a href="javascript:void(0)">
                                <i class="bx bx-home"></i>
                            </a>
                        </div>
                        <div class="appbar__bottom--normal">
                            <i class="bx bx-home"></i>
                        </div>

                        <div class="appbar__bottom--cutout"></div>
                        <div class="appbar__bottom--normal">
                            <a href="javascript:void(0)">
                                <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"/></svg>
                            </a>
                        </div>
                        <div class="appbar__bottom--normal flex--right">
                            <div class="dropdown ms-sm-3 header-item topbar-user">
                                <button type="button" class="btn dropdown-toggle" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="d-flex align-items-center">
                                                <img class="rounded-circle header-profile-user" src="http://localhost/myshop/public/storage/upload/product/featured_image/221222051540-56401634134188F6gHTB1ymRhXfjsK1Rjy1Xaq6zispXad.jpg" alt="Header Avatar">
                                                <span class="text-start ms-xl-2">
                                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Anna Adame</span>
                                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span>
                                                </span>
                                            </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <h6 class="dropdown-header">Welcome Anna!</h6>
                                    <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                    <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                                    <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                                    <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MobileHeader"
    }
</script>

<style scoped>

</style>
