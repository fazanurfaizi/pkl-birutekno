<template>
  <div class="dashboard-container">    
    <div v-if="user.role === 'admin' ">
      <admin-dashboard></admin-dashboard>
    </div>
    <div v-else-if="user.role === 'client' ">
      <client-dashboard></client-dashboard>
    </div>
  </div>
</template>

<script>
import adminDashboard from './admin';
import clientDashboard from './client';
import { mapGetters } from 'vuex';

export default {
  name: 'Dashboard',
  components: { adminDashboard, clientDashboard },  
  computed: {
    ...mapGetters({
      user: 'user/userDetails',
    }),
  },  
};
</script>

<style>

</style>
