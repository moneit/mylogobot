<template>
    <div class="w-100">
        <div class="row">
            <v-flex xs12 md4 d-flex px-3>
                <v-autocomplete
                        v-model="email"
                        :items="emails"
                        label="User Email"
                        :loading="isEmailsLoading"
                        :search-input.sync="emailNeedle"
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
            <v-flex xs12 md4 d-flex px-3>
                <v-autocomplete
                        v-model="package"
                        :items="packages"
                        label="Package"
                        :loading="isPackagesLoading"
                        :search-input.sync="packageNeedle"
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
                <td># {{ props.item.id }}</td>
                <td>{{ props.item.created_at }}</td>
                <td>{{ props.item.user.email }}</td>
                <td>{{ props.item.country.name }}</td>
                <td class="text-capitalize">{{ props.item.package.name }}</td>
                <td>{{ props.item.currency_symbol.symbol }} {{ props.item.price }}</td>
                <td>{{ props.item.status }}</td>
                <td class="justify-content-center layout px-0">
                    <v-icon small class="mr-2" @click="viewItem(props.item)">
                        pageview
                    </v-icon>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import ordersApi from '../../services/api/order.js';
    import usersApi from '../../services/api/users.js';
    import countriesApi from '../../services/api/countries.js';
    import packagesApi from '../../services/api/packages.js';

    export default {
        name: "OrderList",
        data() {
            return {
                items: [],
                loading: true,
                pagination: {},
                headers: [
                    { text: 'Order #', align: 'left', sortable: true, value: 'id', },
                    { text: 'Date', value: 'created_at' },
                    { text: 'User E-Mail', value: 'email', sortable: false },
                    { text: 'Country', value: 'country', sortable: false },
                    { text: 'Package', value: 'package', sortable: false },
                    { text: 'Amount', value: 'price' },
                    { text: 'Status', value: 'status' },
                    { text: 'Actions', value: 'id', sortable: false },
                ],
                totalItems: 0,
                emails: [],
                email: '',
                emailNeedle: null,
                isEmailsLoading: false,
                countries: [],
                country: '',
                countryNeedle: null,
                isCountriesLoading: false,
                packages: [],
                package: '',
                packageNeedle: null,
                isPackagesLoading: false,
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
                    email: this.email,
                    country: this.country,
                    package: this.package,
                };
            }
        },
        watch: {
            pagination: {
                handler () {
                    this.getOrders();
                },
                deep: true
            },
            emailNeedle() {
                if (this.emailNeedle) {
                    this.getUserEmails();
                }
            },
            countryNeedle() {
                if (this.countryNeedle) {
                    this.getCountries();
                }
            },
            packageNeedle() {
                if (this.packageNeedle) {
                    this.getPackages();
                }
            },
            email() {
                this.getOrders();
            },
            country() {
                this.getOrders();
            },
            package() {
                this.getOrders();
            },
        },
        mounted () {
            this.getUserEmails();
            this.getCountries();
            this.getPackages();
        },
        methods: {
            getOrders () {
                this.loading = true;

                return ordersApi.getOrders(this.params)
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
            viewItem(item) {
                if (item.id) {
                    this.$router.push({
                        name: 'order',
                        params: {
                            id: item.id
                        }
                    });
                }
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
                            this.emails = res.payload.slice(0, 10);
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
            getPackages() {
                if (this.isPackagesLoading) return;

                this.isPackagesLoading = true;

                return packagesApi.getNames({
                    search: this.countryNeedle,
                    limit: this.limit,
                })
                    .then((res) => {
                        if (res.status === 'success') {
                            this.packages = res.payload.slice(0, 10);
                        }
                    })
                    .finally(() => {
                        this.isPackagesLoading = false;
                    });
            },
        }
    }
</script>

<style scoped>

</style>