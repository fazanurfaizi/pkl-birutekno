<template>
  <card>
    <div class="row mb-3">
      <div class="col-11">
        <h4 slot="header" class="card-title">Please input your problem ticket form</h4>
      </div>
      <div class="col-1">
        <router-link tag="button" to="/dashboard" class="btn btn-secondary float-right">Back</router-link>
      </div>
    </div>
    <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6">
          <fg-input
            v-model="user.fullname"
            type="text"
            class="form-control"
            placeholder="Enter your name"
            name="name"
            disabled
          />

          <fg-input
            v-model="user.email"
            type="text"
            class="form-control"
            placeholder="Enter your email"
            name="email"
            disabled
          />

          <fg-input
            v-model="user.company.name"
            type="text"
            class="form-control"
            placeholder="Enter your company"
            name="company"
            disabled
          />

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Project</label>
            <div class="col-sm-8">
              <select v-model="ticket.project_id" class="form-control" name="project">
                <option v-for="(project, index) in projects" :key="index" :value="project.id">
                  {{ project.name }}
                </option>
              </select>
            </div>
          </div>

        </div>
        <div class="col-md-6">
          <fg-input
            v-model="ticket.subject"
            type="text"
            class="form-control"
            placeholder="Enter your subject"
            name="subject"
          />

          <textarea
            v-model="ticket.description"
            class="form-control"
            rows="6"
            placeholder="Enter your description"
            name="description"
          />

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">File</label>
            <div class="col-sm-9">
              <div class="custom-file">
                <input
                  type="file"
                  class="custom-file-input"
                  name="attachment"
                  @change="onFileChange"
                >
                <label
                  class="custom-file-label"
                  for="inputGroupFile02"
                  aria-describedby="inputGroupFileAddon02"
                >
                  {{ fileName ? fileName : 'Choose File' }}
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button
              type="button"
              class="btn btn-success btn-lg mt-4"
              @click="openConfirmModal"
            >
              Submit
            </button>
          </div>
        </div>
      </div>
    </form>

    <hr>
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
            @click="saveTicket"
          >
            Yes
          </b-button>
        </div>
      </template>
    </b-modal>
    <div class="clearfix" />
  </card>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
import Card from '@/components/UIComponents/Cards/Card.vue';

export default {
  name: 'TicketAdd',
  components: {
    Card,
  },
  data() {
    return {
      ticket: {
        subject: '',
        description: '',
        file: '',
        project_id: '',
      },
      projects: [],
      confirmModal: false,
      fileName: '',
    };
  },
  computed: {
    ...mapGetters({
      user: 'user/userDetails',
    }),
  },
  mounted() {
    // this.$store.getters.userId
    this.getProjects();
  },
  methods: {
    onFileChange(e) {
      const files = e.target.files || e.data.Transfer.files;
      if (!files.length) {
        return;
      }
      this.ticket.file = files[0];
      this.fileName = e.target.files[0].name;
    },
    getProjects() {
      axios.get('/api/projects/getAll')
        .then((response) => {
          this.projects = response.data.data;
        });
    },
    prepareFormData() {
      const formData = new FormData();
      Object.keys(this.ticket).forEach((key) => {
        if (key === 'body') {
          formData.append(key, JSON.stringify(this.ticket[key]));
        } else {
          formData.append(key, this.ticket[key]);
        }
      });
      return formData;
    },
    resetForm() {
      this.ticket = {
        subject: '',
        description: '',
        file: '',
        project_id: '',
      };
      this.fileName = '';
    },
    saveTicket(e) {
      e.preventDefault();

      const formData = this.prepareFormData();

      axios.post('/api/tickets', formData)
        .then((response) => {
          const data = response.data;
          this.$swal(`${data.message}`, `Your TicketId: ${data.data.id}`, 'success');
          this.resetForm();
          this.confirmModal = false;
        })
        .catch(() => {
          this.$swal('Failed!', 'Tampaknya ada kesalahan dari server', 'error');
          this.resetForm();
          this.confirmModal = false;
        });
    },
    openConfirmModal() {
      this.confirmModal = true;
    },
  },
};
</script>

<style>

</style>
