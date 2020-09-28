<template>
  <div class="dashboard-editor-container">

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
import ticket from './components/ticket';
import project from './components/project';

export default {
  name: 'AdminDashboard',
  components: {
    ticket, project
  },  
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
