<template>
    <div class="row flex-fill">
        <div class="col-md-12 mb-4">
            <router-link :to="{ name: 'users' }" class="btn btn-ghost">
                <i class="logobot-icon icon-angle-left"></i>&nbsp;&nbsp;&nbsp;back
            </router-link>
        </div>
        <template v-if="user.id">
            <div class="col-md-10 offset-md-1">
                <div class="row mb-4 color-primary">
                    User Details
                </div>
                <div class="row mb-4 divider"></div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="color-grey-light">User Name</div>
                        <div class="color-grey">{{ user.name }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">E-Mail</div>
                        <div class="color-grey">{{ user.email }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">Country</div>
                        <div class="color-grey">{{ user.account.country.name }}</div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="color-grey-light">Address</div>
                        <div class="color-grey">{{ user.account.address }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">City</div>
                        <div class="color-grey">{{ user.account.city }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="color-grey-light">State</div>
                        <div class="color-grey">{{ user.account.state }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="color-grey-light">Zipcode</div>
                        <div class="color-grey">{{ user.account.postal_code }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="color-grey-light">Vat number</div>
                        <div class="color-grey">{{ user.account.vat }}</div>
                    </div>
                </div>
                <div class="row mb-4 divider"></div>
                <div class="row mb-4 color-primary">
                    Saved Logos
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 mb-3" v-for="logo in user.logos">
                        <div class="logo-container">
                            <div class="logo" v-html="logo.svg"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 divider"></div>
                <div class="row mb-4 justify-content-end">
                    <button class="btn btn-theme btn-ghost mr-3" @click="loginAs">Login User</button>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import usersApi from '../../services/api/users.js';

    export default {
        name: "UserView",
        data() {
            return {
                user: {}
            }
        },
        mounted() {
            this.getUserDetails();
        },
        methods: {
            getUserDetails() {
                usersApi.getUser(this.$route.params)
                    .then(( data ) => {
                        if (data.status === 'success') {
                            this.user = data.payload;

                            return data.payload;
                        }
                    })
            },
            loginAs() {
                window.location.href = window.location.origin + '/admin/login-as/' + this.user.id;
            }
        }
    }
</script>

<style scoped>
    .divider {
        border-bottom: 1px solid #DEE1E3;
    }
</style>