<template>
  <card>
    <h4 slot="header" class="card-title">Edit Ticket</h4>
    <b-button @click="openDetailModal">Detail Ticket</b-button>
    <form>
      <div class="row">
        <div class="col-md-6">
          <label for="" class="col-sm-3 col-form-label">Start Date</label>
            <div class="col-sm-9">
              <b-form-datepicker 
                class="mb-2 text-lowercase" 
                v-model="ticket.started_at" 
                locale="id"/>
            </div>
        </div>
        <div class="col-md-6">
          <label for="" class="col-sm-3 col-form-label">End Date</label>
            <div class="col-sm-8">
              <b-form-datepicker 
                class="mb-2 text-lowercase" 
                v-model="ticket.ended_at" 
                locale="id"/>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label for="" class="col-sm-3 col-form-label">Status</label>
          <div class="col-sm-10">
            <b-form-select :options="options" v-model="ticket.status"></b-form-select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label for="" class="col-sm-3 col-form-label">Response</label>
          <div class="col-sm-10">
            <b-form-textarea
              id="textarea"              
              v-model="ticket.response"
              placeholder="Enter something..."
              rows="3"
              max-rows="6"
            ></b-form-textarea>
          </div>
        </div>
      </div>      

      <div class="row">
        <div class="col-md-12">                    
            <button type="button" class="btn btn-info btn-fill float-right" @click="openConfirmModal">
              Update Profile
            </button>          
        </div>
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
            @click="updateTicket"
          >
            Yes
          </b-button>
        </div>
      </template>
    </b-modal>    

    <b-modal v-model="detailModal" title="Detail Ticket" hide-footer>
      <table>
        
      </table>
    </b-modal>  

    <div class="clearfix" />
  </card>  
</template>

<script>

import axios from 'axios';
import Card from '@/components/UIComponents/Cards/Card.vue';

export default {
  name: 'EditTicket',
  components: {
    Card
  },
  data() {
    return {      
      ticket: {},
      confirmModal: false,
      detailModal: false,
      selected: null,
      options: [
        { value: null, text: 'Please select an option' },
        { value: 'open', text: 'Open' },
        { value: 'closed', text: 'Closed' },          
      ]
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
          this.ticket = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async updateTicket() {
      this.confirmModal = false;
      const id = this.$route.params && this.$route.params.id;    
      await axios({
        url: `/api/tickets/${id}`,
        data: {
          status: this.ticket.status,
          response: this.ticket.response,
          started_at: this.ticket.started_at,
          ended_at: this.ticket.ended_at
        },
        method: "PUT"
      }).then((response) => {
        const data = response.data;
        this.$swal(`${data.message}`, 'success');
      }).catch((err) => {
        console.log(err)
      })
    },
    openConfirmModal() {
      this.confirmModal = true
    },
    openDetailModal() {
      this.detailModal = !!true
    }
  },
};
</script>

<style>

</style>
