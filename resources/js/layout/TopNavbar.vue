<template>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <router-link to="/dashboard" class="nav-link" style="text-decoration: none">
        Dashboard
      </router-link>
      <button
        type="button"
        class="navbar-toggler navbar-toggler-right"
        :class="{toggled: $sidebar.showSidebar}"
        aria-controls="navigation-index"
        aria-expanded="false"
        aria-label="Toggle navigation"
        @click="toggleSidebar"
      >
        <span class="navbar-toggler-bar burger-lines" />
        <span class="navbar-toggler-bar burger-lines" />
        <span class="navbar-toggler-bar burger-lines" />
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="nav navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="dropdown">
              <i class="nc-icon nc-palette" />
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <router-link to="/dashboard/profile" class="nav-link">
              Profile
            </router-link>
          </li>
          <li class="nav-item">
            <a v-if="loggedIn" small class="nav-link" style="cursor: pointer;" @click="logoutModal=true">
              Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
    <b-modal v-model="logoutModal" title="Are you sure want to logout?">
      <template v-slot:modal-footer>
        <div class="float-left">
          <b-button
            variant="secondary"
            size="sm"
            @click="logoutModal=false"
          >
            Close
          </b-button>
        </div>
        <div class="float-right">
          <b-button
            variant="danger"
            size="sm"
            @click="logout"
          >
            Yes
          </b-button>
        </div>
      </template>
    </b-modal>
  </nav>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      activeNotifications: false,
      logoutModal: false,
    };
  },
  computed: {
    routeName() {
      const { name } = this.$route;
      return this.capitalizeFirstLetter(name);
    },
    ...mapGetters({
      loggedIn: 'user/loggedIn',
    }),
  },
  methods: {
    ...mapActions({
      logoutUser: 'user/logoutUser',
      addNotification: 'application/addNotification',
    }),
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    toggleNotificationDropDown() {
      this.activeNotifications = !this.activeNotifications;
    },
    closeDropDown() {
      this.activeNotifications = false;
    },
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    },
    hideSidebar() {
      this.$sidebar.displaySidebar(false);
    },
    logout() {
      this.logoutUser()
        .then(() => {
          return this.addNotification({
            show: true,
            text: 'Logged out!',
          });
        })
        .then(() => {
          this.$router.push({ name: 'login' });
        });
    },
  },
};
</script>

<style>
</style>
