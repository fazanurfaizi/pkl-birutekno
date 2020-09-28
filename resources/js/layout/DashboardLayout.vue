<template>
  <div class="wrapper">
    <side-bar>
      <mobile-menu slot="content" />
      <sidebar-link to="/dashboard">
        <i class="nc-icon nc-chart-pie-35" />
        <p>Dashboard</p>
      </sidebar-link>
      <!-- <sidebar-link to="/dashboard/tickets">
        <i class="nc-icon nc-circle-09" />
        <p>Tickets</p>
      </sidebar-link>
      <sidebar-link to="/dashboard/projects">
        <i class="nc-icon nc-notes" />
        <p>Projects</p>
      </sidebar-link> -->
    </side-bar>
    <div class="main-panel">
      <top-navbar />

      <dashboard-content @click="toggleSidebar" />

    </div>
  </div>
</template>

<script>
import TopNavbar from './TopNavbar.vue';
import DashboardContent from './Content.vue';
import MobileMenu from './MobileMenu.vue';

export default {
  components: {
    TopNavbar,    
    DashboardContent,
    MobileMenu,
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },
  },
};
</script>

<style lang="scss">
</style>
