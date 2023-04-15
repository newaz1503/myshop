<template>
    <ul class="navbar-nav" id="navbar-nav">
        <li class="nav-item">
            <router-link :to="{name:'admin.dashboard'}" class="nav-link menu-link">
                <div class="icon-sm border-radius-md text-center d-flex align-items-center justify-content-center  me-2">
                    <i class="color fa fa-laptop-house"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </router-link>
        </li>
        <template v-for="(parents,parentIndex) in $root.menus">
            <template v-if="parents.child_menus && Object.keys(parents.child_menus).length > 0 ">
                <li class="nav-item" :key="parentIndex">
                    <a
                        data-bs-toggle="collapse"
                        :href="`#navigationmenu${parents.id}`"
                        aria-expanded="false"
                        :aria-controls="`#navigationmenu${parents.id}`"
                        class="nav-link menu-link"
                    >
                        <div
                            class="icon-sm border-radius-md text-center d-flex align-items-center justify-content-center  me-2">
                            <em :class="'color'+parentIndex" v-if="parents.icon" v-html="parents.icon"></em>
                        </div>
                        <span class="nav-link-text ms-1"> {{ parents.menu_name }} </span>
                    </a>
                    <div class="collapse menu-dropdown" :id="`navigationmenu${parents.id}`">
                        <ul class="nav nav-sm flex-column">
                            <template v-for="(childs,childIndex) in parents.child_menus">
                                <template v-if="childs.child_menus && Object.keys(childs.child_menus).length > 0">
                                    <li :key="childIndex" class="nav-item">
                                        <a
                                            class="nav-link menu-link"
                                            data-bs-toggle="collapse"
                                            :href="`#navigationchildmenu${childs.id}`"
                                            aria-expanded="false"
                                            :aria-controls="`#navigationchildmenu${childs.id}`"
                                        >
                                            <span class="sidenav-mini-icon"> {{ childs.short_title }} </span>
                                            <span class="sidenav-normal"> {{ childs.menu_name }} </span>
                                        </a>
                                        <div
                                            class="collapse menu-dropdown"
                                            :id="`navigationchildmenu${childs.id}`"
                                        >
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item" v-for="(subChild,subchildIndex) in childs.child_menus" :key="subchildIndex"
                                                    v-if="subChild.route_name && $root.checkPermission(subChild.route_name ) ">
                                                    <router-link class="nav-link menu-link"
                                                                 v-if="subChild.params"
                                                                 :to="{name: subChild.route_name,  params: { slug: subChild.params } }">
                                                        <span class="sidenav-mini-icon"> {{ subChild.short_title }} </span>
                                                        <span class="sidenav-normal"> {{ subChild.menu_name }} </span>
                                                    </router-link>

                                                    <!-- SINGLE MENU -->
                                                    <router-link class="nav-link menu-link" v-else :to="{ name: subChild.route_name }">
                                                        <span class="sidenav-mini-icon"> {{ subChild.short_title }} </span>
                                                        <span class="sidenav-normal"> {{ subChild.menu_name }} </span>
                                                    </router-link>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </template>
                                <template v-else>
                                    <li class="nav-item" :key="childIndex"
                                        v-if="childs.route_name && $root.checkPermission(childs.route_name ) ">
                                        <router-link class="nav-link menu-link"
                                                     v-if="childs.params"
                                                     :to="{name: childs.route_name,  params: { slug: childs.params } }">
                                            <span class="sidenav-mini-icon"> {{ childs.short_title }} </span>
                                            <span class="sidenav-normal"> {{ childs.menu_name }} </span>
                                        </router-link>

                                        <!-- SINGLE MENU -->
                                        <router-link class="nav-link menu-link" v-else :to="{ name: childs.route_name }">
                                            <span class="sidenav-mini-icon"> {{ childs.short_title }} </span>
                                            <span class="sidenav-normal"> {{ childs.menu_name }} </span>
                                        </router-link>
                                    </li>
                                </template>
                            </template>
                        </ul>
                    </div>
                </li>
            </template>
            <template v-else>
                <li class="nav-item" :key="parentIndex"
                    v-if="parents.route_name && $root.checkPermission(parents.route_name ) ">
                    <router-link class="nav-link menu-link"
                                 v-if="parents.params"
                                 :to="{name: parents.route_name,  params: { slug: parents.params } }">
                        <div
                            class="icon-sm border-radius-md text-center d-flex align-items-center justify-content-center  me-2">
                            <em :class="'color'+parentIndex" v-if="parents.icon" v-html="parents.icon"></em>
                        </div>
                        <span class="nav-link-text ms-1"> {{ parents.menu_name }} </span>
                    </router-link>
                    <router-link class="nav-link menu-link" v-else :to="{ name: parents.route_name }">
                        <div
                            class="icon-sm border-radius-md text-center d-flex align-items-center justify-content-center  me-2">
                            <em :class="'color'+parentIndex" v-if="parents.icon" v-html="parents.icon"></em>
                        </div>
                        <span class="nav-link-text ms-1"> {{ parents.menu_name }} </span>
                    </router-link>
                </li>
            </template>
        </template>
    </ul>
</template>

<script>
    export default {
        name: "SidebarComponent"
    }
</script>

<style>

</style>
