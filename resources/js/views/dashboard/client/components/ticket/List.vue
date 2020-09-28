<template>
  <div class="container" style="padding-top: 30px">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title float-left">Tickets</h5>
            <router-link to="/dashboard/add-ticket" tag="button" class="btn btn-secondary float-right">Add Ticket</router-link>
          </div>
          <div class="card-body">
            <datatable
              :items="items"
              :item="item"
              :fields="fields"
              :meta="meta"
              :edit-url="'/a/b'"
              @per_page="handlePerPage"
              @pagination="handlePagination"
              @search="handleSearch"
              @sort="handleSort"
              @detail="handleDetail"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import Datatable from './Datatable';
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
  name: 'TicketList',
  components: {
    Datatable,
  },
  computed: {
    ...mapGetters({
      userDetails: 'user/userDetails',
    }),
  },
  data() {
    return {
      fields: [
        { key: 'id', sortable: true },
        { key: 'subject', sortable: true },
        { key: 'status', sortable: true },
        { key: 'created_at', sortable: true },
        { key: 'actions', sortable: false },
      ],
      items: [],
      meta: [],
      current_page: 1,
      per_page: 10,
      search: '',
      sortBy: 'created_at',
      sortByDesc: false,
      item: {},
    };
  },
  created() {
    this.loadTicketsData();
  },
  methods: {
    loadTicketsData() {    
      const current_page = this.search === '' ? this.current_page : this.current_page;
      axios.get('/api/tickets', {
        params: {
          page: current_page,
          per_page: this.per_page,
          q: this.search,
          sortby: this.sortBy,
          sortbydesc: this.sortByDesc ? 'DESC' : 'ASC',
        },
      })
        .then((response) => {
          const getData = response.data.data;
          this.items = getData.data;
          this.meta = {
            total: getData.total,
            current_page: getData.current_page,
            per_page: getData.per_page,
            from: getData.from,
            to: getData.to,
          };
        });
    },
    getDetailTicket(id) {
      axios.get(`/api/tickets/${id}`)
        .then((response) => {
          this.item = response.data.data;
        });
    },
    handlePerPage(val) {
      this.per_page = val;
      this.loadTicketsData();
    },
    handlePagination(val) {
      this.current_page = val;
      this.loadTicketsData();
    },
    handleSearch(val) {
      this.search = val;
      this.loadTicketsData();
    },
    handleSort(val) {
      this.sortBy = val.sortBy;
      this.sortByDesc = val.sortDesc;

      this.loadTicketsData();
    },
    handleDetail(val) {
      this.getDetailTicket(val.id);
    },
  },
};
</script>

<style>

</style>
