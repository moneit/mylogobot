<template>
    <div class="w-100">
        <div class="row justify-content-end">
            <v-btn class="secondary">Export</v-btn>
            <v-btn class="primary" @click="getRecommendations">Show</v-btn>
        </div>
        <div class="row">
            <v-flex xs12 md3 d-flex px-3>
                <v-text-field
                        disabled
                        value="From"
                ></v-text-field>
            </v-flex>
            <v-flex xs12 md3 d-flex px-3>
                <v-datetime-picker
                        v-model="startDatetime"
                        :text-field-props="textFieldProps"
                        :date-picker-props="dateProps"
                        :time-picker-props="timeProps"
                        time-format="HH:mm:ss"
                ></v-datetime-picker>
            </v-flex>
            <v-flex xs12 md3 d-flex px-3>
                <v-text-field
                        disabled
                        value="To"
                ></v-text-field>
            </v-flex>
            <v-flex xs12 md3 d-flex px-3>
                <v-datetime-picker
                        v-model="endDatetime"
                        :text-field-props="textFieldProps"
                        :date-picker-props="dateProps"
                        :time-picker-props="timeProps"
                        time-format="HH:mm:ss"
                ></v-datetime-picker>
            </v-flex>
        </div>
        <div class="row">
            <v-flex xs12 px-3>
                <v-checkbox v-model="exportCompanyName" label="Export Company Name"></v-checkbox>
            </v-flex>
            <v-flex xs12 px-3>
                <v-checkbox v-model="exportSlogan" label="Export Slogan"></v-checkbox>
            </v-flex>
            <v-flex xs12 px-3>
                <v-checkbox v-model="exportKeyword" label="Export Keyword"></v-checkbox>
            </v-flex>
            <v-flex xs12 px-3>
                <v-checkbox v-model="exportUsedDate" label="Export Used Date"></v-checkbox>
            </v-flex>
            <v-flex xs12 px-3>
                <v-checkbox v-model="exportUserEmail" label="Export User Email"></v-checkbox>
            </v-flex>
            <v-flex xs12 px-3>
                <v-checkbox v-model="exportUserCountry" label="Export User Country"></v-checkbox>
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
                <td v-if="exportCompanyName">{{ props.item.company_name }}</td>
                <td v-if="exportSlogan">{{ props.item.slogan }}</td>
                <td v-if="exportKeyword">{{ props.item.details }}</td>
                <td v-if="exportUsedDate">{{ props.item.created_at }}</td>
                <td v-if="exportUserEmail">{{ props.item.user && props.item.user.email ? props.item.user.email : '' }}</td>
                <td v-if="exportUserCountry">{{ props.item.user && props.item.user.account && props.item.user.account.country && props.item.user.account.country.name ? props.item.user.account.country.name : '' }}</td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
  import recommendationTracksApi from '../../services/api/recommendationTracks.js';

  export default {
    name: "RecommendationList",
    data() {
      return {
        startDatetime: null,
        endDatetime: null,
        textFieldProps: {
          appendIcon: 'event'
        },
        dateProps: {
          headerColor: 'blue'
        },
        timeProps: {
          useSeconds: true,
          ampmInTitle: true
        },

        items: [],
        loading: true,
        pagination: {},
        headers: [
          { text: 'Company Name', align: 'left', sortable: true, value: 'company_name', },
          { text: 'Slogan', value: 'slogan', sortable: true },
          { text: 'Keyword', value: 'details', sortable: false },
          { text: 'Used Date', value: 'created_at', sortable: true },
          { text: 'User Email', value: 'user.email', sortable: false },
          { text: 'Country', value: 'user.account.country.name', sortable: false },
        ],
        totalItems: 0,

        limit: 10,

        exportCompanyName: true,
        exportSlogan: true,
        exportKeyword: true,
        exportUsedDate: true,
        exportUserEmail: true,
        exportUserCountry: true,
      }
    },
    computed: {
      params() {
        return {
          current_page: this.pagination.page,
          per_page: this.pagination.rowsPerPage,
          order_column: this.pagination.sortBy,
          order_direction: this.pagination.descending ? 'desc' : 'asc',
          start_date_time: this.startDatetime,
          end_date_time: this.endDatetime,
        };
      }
    },
    watch: {
      pagination: {
        handler () {
          this.getRecommendations();
        },
        deep: true
      },
      exportCompanyName() {
        if (this.exportCompanyName) {
          if (this.headers[0].text !== 'Company Name') {
            this.headers.splice(0, 0, { text: 'Company Name', align: 'left', sortable: true, value: 'company_name', });
          }
        } else {
          if (this.headers[0].text === 'Company Name') {
            this.headers.splice(0, 1);
          }
        }
        this.headers = this.headers.slice();
      },
      exportSlogan() {
        if (this.exportSlogan) {
          if (this.headers[1].text !== 'Slogan') {
            this.headers.splice(1, 0, { text: 'Slogan', value: 'slogan', sortable: true });
          }
        } else {
          if (this.headers[1].text === 'Slogan') {
            this.headers.splice(1, 1);
          }
        }
        this.headers = this.headers.slice();
      },
      exportKeyword() {
        if (this.exportKeyword) {
          if (this.headers[2].text !== 'Keyword') {
            this.headers.splice(2, 0, { text: 'Keyword', value: 'details', sortable: false });
          }
        } else {
          if (this.headers[2].text === 'Keyword') {
            this.headers.splice(2, 1);
          }
        }
        this.headers = this.headers.slice();
      },
      exportUsedDate() {
        if (this.exportUsedDate) {
          if (this.headers[3].text !== 'Used Date') {
            this.headers.splice(3, 0, { text: 'Used Date', value: 'created_at', sortable: true });
          }
        } else {
          if (this.headers[3].text === 'Used Date') {
            this.headers.splice(3, 1);
          }
        }
        this.headers = this.headers.slice();
      },
      exportUserEmail() {
        if (this.exportUsedDate) {
          if (this.headers[4].text !== 'User Email') {
            this.headers.splice(4, 0, { text: 'User Email', value: 'user.email', sortable: true });
          }
        } else {
          if (this.headers[4].text === 'User Email') {
            this.headers.splice(4, 1);
          }
        }
        this.headers = this.headers.slice();
      },
    },
    mounted () {

    },
    methods: {
      getRecommendations () {
        this.loading = true;

        return recommendationTracksApi.get(this.params)
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
    }
  }
</script>

<style scoped>

</style>