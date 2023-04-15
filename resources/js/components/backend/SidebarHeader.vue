<template>
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <router-link :to="{name:'admin.dashboard'}" class="logo">
           <span class="logo-sm" v-if="$root.settings.favicon">
                <img :src="$root.settings.favicon" alt="" height="22">
            </span>
            <span class="logo-lg" v-if="$root.settings.logo">
                <img :src="$root.settings.logo" alt="" height="70">
            </span>
        </router-link>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
</template>

<script>
    export default {
        name: "SidebarHeader",
    }
</script>

<style>
    .text-logo {
        color: var(--vz-primary);
    }
</style>
