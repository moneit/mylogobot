<template>
    <div class="w-100">
        <div class="row">
            <v-flex xs12 md4 d-flex px-3>
                <v-autocomplete
                        v-model="userName"
                        :items="userNames"
                        label="User Name"
                        :loading="isUserNamesLoading"
                        :search-input.sync="userNameNeedle"
                        :clearable="true"
                ></v-autocomplete>
            </v-flex>
            <v-flex xs12 md4 d-flex px-3>
                <v-autocomplete
                        v-model="userEmail"
                        :items="userEmails"
                        label="User E-mail"
                        :loading="isUserEmailsLoading"
                        :search-input.sync="userEmailNeedle"
                        :clearable="true"
                ></v-autocomplete>
            </v-flex>
            <v-flex xs12 md4 d-flex px-3>
                <v-autocomplete
                        v-model="country"
                        :items="countries"
                        label="Country"
                        :loading="isCountriesLoading"
                        :search-input.sync="countryNeedle"
                        :clearable="true"
                ></v-autocomplete>
            </v-flex>
        </div>
        <v-data-table
                :headers="headers"
                :items="items"
                :total-items="totalItems"
                :pagination.sync="pagination"
                :loading="loading"
                class="elevation-1 w-100 fill-height"
        >
            <template v-slot:items="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.email }}</td>
                <td>{{ props.item.account.country.name }}</td>
                <td>{{ props.item.created_at }}</td>
                <td class="px-0">
                    <span class="pointer" @click="loginUser(props.item)">
                        <v-icon small class="ml-4 mr-2">
                            input
                        </v-icon>
                        Login User
                    </span>
                    <span class="pointer" @click="view(props.item)">
                        <v-icon small class="ml-4 mr-2">
                            account_circle
                        </v-icon>
                        User Profile
                    </span>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
  import usersApi from '../../services/api/users.js';
  import countriesApi from '../../services/api/countries.js';

  export default {
    name: "UserList",
    data() {
      return {
        items: [],
        loading: true,
        pagination: {},
        headers: [
          { text: 'User Name', align: 'left', sortable: true, value: 'name', },
          { text: 'User E-Mail', value: 'email', sortable: true },
          { text: 'Country', value: 'country', sortable: false },
          { text: 'Registration Date', value: 'created_at', sortable: true },
          { text: 'Actions', value: 'id', sortable: false },
        ],
        totalItems: 0,

        userNames: [],
        userName: '',
        userNameNeedle: null,
        isUserNamesLoading: false,

        countries: [],
        country: '',
        countryNeedle: null,
        isCountriesLoading: false,

        userEmails: [],
        userEmail: '',
        userEmailNeedle: null,
        isUserEmailsLoading: false,

        limit: 10,
      }
    },
    computed: {
      params() {
        return {
          current_page: this.pagination.page,
          per_page: this.pagination.rowsPerPage,
          order_column: this.pagination.sortBy,
          order_direction: this.pagination.descending ? 'desc' : 'asc',
          user_name: this.userName,
          user_email: this.userEmail,
          country: this.country,
        };
      }
    },
    watch: {
      pagination: {
        handler () {
          this.getUsers();
        },
        deep: true
      },
      userNameNeedle() {
        if (this.userNameNeedle) {
          this.getUserNames();
        }
      },
      userEmailNeedle() {
        if (this.userEmailNeedle) {
          this.getUserEmails();
        }
      },
      countryNeedle() {
        if (this.countryNeedle) {
          this.getCountries();
        }
      },
      userName() {
        this.getUsers();
      },
      userEmail() {
        this.getUsers();
      },
      country() {
        this.getUsers();
      },
    },
    mounted () {
      this.getUserNames();
      this.getUserEmails();
      this.getCountries();
    },
    methods: {
      getUsers () {
        this.loading = true;

        return usersApi.getUsers(this.params)
          .then(( data ) => {
            if (data.status === 'success') {
              this.loading = false;
              this.items = data.payload.data;
              this.pagination = Object.assign(this.pagination, {
                page: data.payload.current_page,
                rowsPerPage: Number(data.payload.per_page),
              });
              this.totalItems =  data.payload.total;

              return data.payload;
            }
          });
      },
      loginUser(user) {
        window.location.href = window.location.origin + '/admin/login-as/' + user.id;
      },
      view(user) {
        if (user.id) {
          this.$router.push({
            name: 'user',
            params: {
              id: user.id
            }
          });
        }
      },
      getUserNames() {
        if (this.isUserNamesLoading) return;

        this.isUserNamesLoading = true;

        return usersApi.getNames({
          search: this.userNameNeedle,
          limit: this.limit,
        })
          .then((res) => {
            if (res.status === 'success') {
              this.userNames = res.payload.slice(0, 10);
            }
          })
          .finally(() => {
            this.isUserNamesLoading = false;
          });
      },
      getUserEmails() {
        if (this.isEmailsLoading) return;

        this.isEmailsLoading = true;

        return usersApi.getEmails({
          search: this.emailNeedle,
          limit: this.limit,
        })
          .then((res) => {
            if (res.status === 'success') {
              this.userEmails = res.payload.slice(0, 10);
            }
          })
          .finally(() => {
            this.isEmailsLoading = false;
          });
      },
      getCountries() {
        if (this.isCountriesLoading) return;

        this.isCountriesLoading = true;

        return countriesApi.getNames({
          search: this.countryNeedle,
          limit: this.limit,
        })
          .then((res) => {
            if (res.status === 'success') {
              this.countries = res.payload.slice(0, 10);
            }
          })
          .finally(() => {
            this.isCountriesLoading = false;
          });
      },
    }
  }
</script>

<style scoped>

</style>