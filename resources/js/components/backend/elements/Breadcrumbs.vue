<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{breadcrumbLevels[0] ? breadcrumbLevels[0][Object.keys(breadcrumbLevels[0]).length - 1]["title"] : "" }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <router-link class="breadcrumb-link" :to="{ name: 'admin.dashboard' }">Dashboard</router-link>
                        </li>
                        <template v-for="(menu, index1) in breadcrumbLevels[0]">
                            <li v-if="menu.route !== $route.name" class="breadcrumb-item">
                                <router-link class="text-capitalize" :to="{name: menu.route, params: { slug: menu.slug ? menu.slug : '' },}">
                                    {{ menu.title }}
                                </router-link>
                            </li>
                            <li  :key="index1" v-if="menu.route === $route.name" class="breadcrumb-item active text-capitalize" aria-current="page">
                                {{ menu.title }}
                            </li>
                        </template>
                    </ol>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        removeMenu(index) {
            breadcrumbs.dispatch("removeMenu", index);
        },
    },
    computed: {
        breadcrumbLevels() {
            return breadcrumbs.state.breadcrumbLevels;
        },
        menuTags() {
            return breadcrumbs.state.menuTags;
        },
    },
};
</script>
