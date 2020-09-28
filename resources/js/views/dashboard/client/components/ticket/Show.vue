<template>
  <div class="container">    
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Ticket ID</th>
          <th scope="col">{{ ticket.id }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">Name </th>
          <th scope="row">{{ ticket.user ? ticket.user.fullname : '' }}</th>
        </tr>
        <tr>
          <th scope="row">Email </th>
          <th scope="row">{{ ticket.user ? ticket.user.email : '' }}</th>
        </tr>
        <tr>
          <th scope="row">Company </th>
          <th scope="row">{{ ticket.user ? ticket.user.company : '' }}</th>
        </tr>
        <tr>
          <th scope="row">Category </th>
          <th scope="row">{{ ticket.project ? ticket.project.category.name : '' }}</th>
        </tr>
        <tr>
          <th scope="row">Subject </th>
          <th scope="row">{{ ticket.subject }}</th>
        </tr>
        <tr>
          <th scope="row">Description </th>
          <th scope="row">{{ ticket.description }}</th>
        </tr>
        <tr>
          <th scope="row">File </th>
          <th scope="row">
            <a href="">{{ ticket.file }}</a>
          </th>
        </tr>
      </tbody>
    </table>
    <div class="mt-4">
      <div class="col-sm">
        <h5 class="text--black">Ticket Status</h5>
      </div>
    </div>
    <div class="mt-4">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Status</th>
            <th scope="col">
              <h5>
                <span class="badge badge-warning">{{ ticket.status }}</span>
              </h5>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Respond </th>
            <th scope="row">{{ ticket.response }}</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
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
    // this.$router.push(`/dashboard/show-ticket/${id}`);
    this.getTicket(id);
  },
  methods: {
    async getTicket(id) {
      axios.get(`/api/tickets/${id}`)
        .then((response) => {
          this.ticket = response.data.data;
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
