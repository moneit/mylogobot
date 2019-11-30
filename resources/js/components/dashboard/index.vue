<template>
    <v-app id="inspire">
        <v-toolbar
                color="blue"
                dark
                fixed
                app
                clipped-right
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Admin Dashboard</v-toolbar-title>
            <v-spacer></v-spacer>
            <!--<v-toolbar-side-icon @click.stop=""></v-toolbar-side-icon>-->
        </v-toolbar>
        <v-navigation-drawer
                fixed
                v-model="drawer"
                stateless
                app
                value="true"
        >
            <v-list>
                <v-list-tile @click="goToOverview">
                    <!--<v-list-tile-action>-->
                    <!--<v-icon>home</v-icon>-->
                    <!--</v-list-tile-action>-->
                    <v-list-tile-title class="text-center">Overview</v-list-tile-title>
                </v-list-tile>

                <v-list-tile @click="goToOrders">
                    <!--<v-list-tile-action>-->
                    <!--<v-icon>product</v-icon>-->
                    <!--</v-list-tile-action>-->
                    <v-list-tile-title class="text-center">Orders</v-list-tile-title>
                </v-list-tile>

                <v-list-tile @click="goToUsers">
                    <!--<v-list-tile-action>-->
                    <!--<v-icon>account_circle</v-icon>-->
                    <!--</v-list-tile-action>-->
                    <v-list-tile-title class="text-center">Users</v-list-tile-title>
                </v-list-tile>

                <v-list-tile @click="goToRecommendations">
                    <!--<v-list-tile-action>-->
                    <!--<v-icon>account_circle</v-icon>-->
                    <!--</v-list-tile-action>-->
                    <v-list-tile-title class="text-center">Recommendations</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-content>
            <v-container fluid fill-height align-items-baseline>
                <router-view></router-view>
            </v-container>
        </v-content>
        <!--<v-footer color="blue-grey" class="white&#45;&#45;text" app>-->
        <!--<span>Vuetify</span>-->
        <!--<v-spacer></v-spacer>-->
        <!--<span>&copy; 2017</span>-->
        <!--</v-footer>-->
    </v-app>
</template>

<script>
  export default {
    name: "dashboard",
    props: {
      source: String,
    },
    data() {
      return {
        drawer: true,
        drawerRight: false,
        right: null,
        left: null,
      }
    },
    methods: {
      goToOverview() {
        this.$router.push('/');
      },
      goToOrders() {
        this.$router.push('/orders');
      },
      goToUsers() {
        this.$router.push('/users');
      },
      goToRecommendations() {
        this.$router.push('/recommendations');
      },
    }
  }
</script>

<style scoped>

</style>