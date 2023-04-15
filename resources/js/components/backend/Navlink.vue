<template>
    <router-link class="nav-link" :to="href">
        <span class="sidenav-mini-icon"> {{short_title}} </span>
        <span class="sidenav-normal"> {{ title }} </span>
    </router-link>
</template>

<script>
    export default {
        name: "Navlink",
        props:['href','short_title','title']
    }
</script>

<style scoped>

</style>
