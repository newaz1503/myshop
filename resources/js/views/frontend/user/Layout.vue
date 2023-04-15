<template>
    <section class="user-panel mt-4">
        <div class="container">
            <div class="row">
                <div class="col-xxl-3 col-lg-3">
                    <div class="card">
                        <div class="card-body p-0 pt-4 pb-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img :src="profile.avatar"
                                         class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                         alt="">
                                </div>
                                <h5 class="fs-16 mb-1">{{ profile.name }}</h5>
                                <p class="text-muted mb-0">{{ profile.email}}</p>
                            </div>
                            <div class="list-group mt-4">
                                <router-link :to="{ name: 'user.dashboard' }"
                                   class="list-group-item list-group-item-action fs-14">
                                    <i class=" ri-home-4-line align-middle fs-18 me-2"></i> Dashboard
                                </router-link>
                                <router-link :to="{ name: 'user.profile' }"
                                   class="list-group-item list-group-item-action fs-14"><i
                                    class="ri-user-6-line align-middle fs-18 me-2"></i>Profile
                                </router-link>
                                <router-link :to="{ name: 'user.orders' }"
                                   class="list-group-item list-group-item-action fs-14"><i
                                    class="ri-shopping-bag-3-line align-middle fs-18 me-2"></i>My Orders
                                </router-link>
                                <router-link :to="{ name: 'user.trackorder' }"
                                             class="list-group-item list-group-item-action fs-14"><i
                                    class="ri-history-line align-middle fs-18 me-2"></i>Track Order
                                </router-link>
                                <router-link :to="{ name: 'user.wisthlist' }"
                                   class="list-group-item list-group-item-action fs-14"><i
                                    class="ri-hearts-line align-middle fs-18 me-2"></i>Wishlist
                                </router-link>
                                <router-link :to="{name:'user.change_password'}"
                                   class="list-group-item list-group-item-action fs-14"><i
                                    class="ri-key-2-line align-middle fs-18 me-2"></i>Change Password
                                </router-link>



                                <a href="javascript:" @click="logout"
                                             class="list-group-item list-group-item-action fs-14"><i
                                    class="ri-logout-circle-line align-middle fs-18 me-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-9 col-lg-9">
                   <router-view></router-view>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
    export default {
        name:"Layout",
        data(){
            return{
                profile:{}
            }
        },
        methods: {
            logout() {
                User.logout();
            },
        },
        created() {
          axios.get('user/get-profile-info').then(res => {
              this.profile = res.data;
          })
        },
        // beforeCreate() {
        //     if (!User.id()) {
        //         User.logout();
        //     }
        // },
    };
</script>
