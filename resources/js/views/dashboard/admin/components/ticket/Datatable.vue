<template>
  <div class="row">
    <div class="col-md-4 mb-2">
      <div class="form-inline">
        <label class="mr-2">Showing</label>
        <select v-model="meta.per_page" class="form-control" @change="loadPerPage">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <label class="ml-2">Entries</label>
      </div>
    </div>

    <div class="col-md-4 offset-md-4">
      <div class="form-inline float-right">
        <label class="mr-2">Search</label>
        <input type="text" class="form-control" @input="search">
      </div>
    </div>

    <div class="col-md-12">
      <b-table
        striped
        hover
        :items="items"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        show-empty
      >
        <template v-slot:cell(actions)="row">
          <!-- <button class="btn">
            <b-icon icon="chat-dots" font-scale="2" variant="secondary" />
          </button> -->
          <button class="btn btn-warning btn-sm" @click="detail(row)">Detail</button>
          <button class="btn btn-warning btn-sm" @click="editTicket(row)">Edit</button>
        </template>
      </b-table>
    </div>

    <div class="col-md-6">
      <p>Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} items</p>
    </div>

    <div class="col-md-6">
      <b-pagination
        v-model="meta.current_page"
        :total-rows="meta.total"
        :per-page="meta.per_page"
        align="right"
        aria-controls="dw-datatable"
        @change="changePage"
      />
    </div>    
  </div>
</template>

<script>

import _ from 'lodash';

export default {
  name: 'DataTable',
  props: {
    title: {
      type: String,
      default: 'Ticket Tracking Results',
    },
    editUrl: {
      type: String,
      default: null,
    },
    items: {
      type: Array,
      required: true,
    },
    fields: {
      type: Array,
      required: true,
    },
    meta: {
      required: true,
    },    
  },
  data() {
    return {
      sortBy: null,
      sortDesc: false,          
      selected: null,
      user: null,      
    };
  },
  watch: {
    sortBy(val) {
      this.$emit('sort', {
        sortBy: this.sortBy,
        sortDesc: this.sortDesc,
      });
    },
    sortDesc(val) {
      this.$emit('sort', {
        sortBy: this.sortBy,
        sortDesc: this.sortDesc,
      });
    },
  },
  methods: {
    loadPerPage(val) {
      this.$emit('per_page', this.meta.per_page);
    },
    changePage(val) {
      this.$emit('pagination', val);
    },
    search: _.debounce(function(e) {
      this.$emit('search', e.target.value);
    }, 500),
    openDetailModal(row) {
      this.detailModal = true;
      this.selected = row.item;
      this.$emit('detail', this.selected);
    },
    detail(row) {
      this.selected = row.item;
      this.$emit('detail', this.selected);
      this.$router.push({
        name: 'show-ticket',
        params: {
          id: this.selected.id,
        },
      })
    },      
    editTicket(row) {
      this.selected = row.item;
      this.$emit('edit', this.selected);
      this.$router.push({
        name: 'edit-ticket',
        params: { 
            id: this.selected.id 
        },
      });
    },
  },
};
</script>

<style>

</style>
