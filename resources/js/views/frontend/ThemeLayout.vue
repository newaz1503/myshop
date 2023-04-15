<template>
    <div class="">
        <template v-if="$root.global.theme_layout == 'layout_one'">
            <Home></Home>
        </template>
        <template v-if="$root.global.theme_layout == 'layout_two'">
            <Home2></Home2>
        </template>
        <template v-if="$root.global.theme_layout == 'layout_three'">
            <Home3></Home3>
        </template>
    </div>
</template>

<script>
    import Home from "./Home";
    import Home2 from "./Home2";
    import Home3 from "./Home3";
    export default {
        name: "ThemeLayout",
        components: {Home3, Home2, Home}
    }
</script>

<style scoped>

</style>
