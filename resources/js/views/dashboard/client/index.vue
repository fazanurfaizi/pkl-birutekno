<template>
  <div class="dashboard-editor-container">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5 col-md-4">
                  <div class="icon-big text-center icon-warning">
                    <b-icon icon="bookmark-check" font-scale="3" variant="danger" />
                  </div>
                </div>
                <div class="col-7 col-md-8">
                  <div class="numbers">
                    <p class="card-category">Open Tickets</p>
                    <p class="card-title">{{ user.openTicketCount }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer" />
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5 col-md-4">
                  <div class="icon-big text-center icon-warning">
                    <b-icon icon="bookmark-dash" font-scale="3" variant="success" />
                  </div>
                </div>
                <div class="col-7 col-md-8">
                  <div class="numbers">
                    <p class="card-category">Closed Tickets</p>
                    <p class="card-title">{{ user.closedTicketCount }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer" />
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5 col-md-4">
                  <div class="icon-big text-center icon-warning">
                    <b-icon icon="app-indicator" font-scale="3" variant="warning" />
                  </div>
                </div>
                <div class="col-7 col-md-8">
                  <div class="numbers">
                    <p class="card-category">Aplikasi</p>
                    <p class="card-title">{{ user.projectCount }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer" />
          </div>
        </div>
      </div>
    </div>    
    <hr>
    <div>
      <b-tabs content-class="mt-3">
        <b-tab title="Tickets" active>
          <ticket />
        </b-tab>
        <b-tab title="Projects">
          <project />
        </b-tab>        
      </b-tabs>
    </div>    
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import ticket from './components/ticket';
import project from './components/project';

export default {
  name: 'ClientDashboard',
  components: {
    ticket, project,
  },
  computed: {
    ...mapGetters({
      user: 'user/userDetails',
    }),
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  .dashboard-editor-container {
    background-color: #e3e3e3;
    min-height: 100vh;
    padding: 50px 60px 0px;
    .pan-info-roles {
      font-size: 12px;
      font-weight: 700;
      color: #333;
      display: block;
    }
    .info-container {
      position: relative;
      margin-left: 190px;
      height: 150px;
      line-height: 200px;
      .display_name {
        font-size: 48px;
        line-height: 48px;
        color: #212121;
        position: absolute;
        top: 25px;
      }
    }
  }
</style>
