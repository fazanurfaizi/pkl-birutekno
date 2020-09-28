<template>
  <div :class="{'nav-open': $sidebar.showSidebar}">
    <router-view />
    <v-snackbar
      v-for="(snackbar, index) in allNotifications"
      :key="index"
      v-model="snackbar.show"
      @input="updateNotification($event, index)"
    >
      {{ snackbar.text }}
      <v-btn
        color="pink"
        text
        @click="removeNotification(index)"
      >
        Close
      </v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'App',
  created() {
    this.checkUserState()
      .then(() => {
        if (this.isLoggedIn) {
          this.me().then(() => {
            console.log(this.$can('view-developer-dashboard'));
          });
        }
      });
  },
  computed: {
    ...mapGetters({
      isLoggedIn: 'user/loggedIn',
      allNotifications: 'application/notifications',
    }),
  },
  methods: {
    ...mapActions({
      checkUserState: 'user/setLoggedInState',
      removeNotification: 'application/removeNotification',
      addNotification: 'application/addNotification',
      me: 'user/me',
    }),
    updateNotification(show, index) {
      if (!show) {
        this.removeNotification(index);
      }
    },
  },
};
</script>

<style lang="scss">
    .vue-notifyjs.notifications{
        .list-move {
            transition: transform 0.3s, opacity 0.4s;
        }
        .list-item {
            display: inline-block;
            margin-right: 10px;
        }
        .list-enter-active {
            transition: transform 0.2s ease-in, opacity 0.4s ease-in;
        }
        .list-leave-active {
            transition: transform 1s ease-out, opacity 0.4s ease-out;
        }
        .list-enter {
            opacity: 0;
            transform: scale(1.1);
        }
        .list-leave-to {
            opacity: 0;
            transform: scale(1.2, 0.7);
            }
    }
</style>
