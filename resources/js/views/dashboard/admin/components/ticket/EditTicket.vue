<template>
  <div class="container mt-5">
    <form method="POST" class="mt-4">
      <div class="row text2">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Start Date</label>
            <div class="col-sm-8">
              <datetime />
            </div>
          </div>
          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">End Date</label>
            <div class="col-sm-8">
              <datetime />
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
              <select class="form-control">
                <option>Open</option>
                <option>Status</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Response</label>
            <div class="col-sm-9">
              <textarea
                class="form-control"
                rows="6"
                placeholder="Enter your description"
                name="description"
              />
            </div>
          </div>
        </div>
        <button
          type="button"
          class="btn btn-success btn-lg mt-4"
          @click="openConfirmModal"
        >
          Edit
        </button>
      </div>
    </form>
    <b-modal v-model="confirmModal" title="Are You sure">
      <p>Create a new Ticket</p>
      <template v-slot:modal-footer>
        <div class="float-right">
          <b-button
            variant="secondary"
            size="sm"
            @click="confirmModal=false"
          >
            Close
          </b-button>
        </div>
        <div class="float-left">
          <b-button
            variant="secondary"
            size="sm"
            data-save
            @click="editTicket"
          >
            Yes
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>

import axios from 'axios';
import { Datetime } from 'vue-datetime';

export default {
  name: 'EditTicket',
  components: {
    Datetime,
  },
  data() {
    return {
      ticket: {},
    };
  },
  watch: {
    '$route': 'getTicket',
  },
  created() {
    const id = this.$route.params && this.$route.params.id;    
    this.getTicket(id);
  },
  methods: {
    async getTicket(id) {
      axios.get(`/api/tickets/${id}`)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>

</style>
