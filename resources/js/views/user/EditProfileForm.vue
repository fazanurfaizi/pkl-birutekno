<template>
  <card>
    <h4 slot="header" class="card-title">Edit Profile</h4>
    <form>
      <div class="row">
        <div class="col-md-6">
          <fg-input
            v-model="userDetails.username"
            type="text"
            label="Username"
            placeholder="Username"
          />
        </div>
        <div class="col-md-6">
          <fg-input
            v-model="userDetails.email"
            type="email"
            label="Email"
            placeholder="Email"
          />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <fg-input
            v-model="userDetails.fullname"
            type="text"
            label="FullName"
            placeholder="FullName"
          />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button type="submit" class="btn btn-info btn-fill float-right" @click.prevent="changeDetails">
              Update Profile
            </button>
          </div>
        </div>
      </div>
    </form>

    <hr>

    <div class="row">
      <div class="col-md-12 text-center">
        <label for="change-password-form" class="text-bold text-black-50">Change Password</label>
      </div>
    </div>

    <v-form ref="changePasswordForm">
      <div class="row">
        <div class="col-md-12">
          <fg-input
            v-model="user.oldPassword"
            :rules="[...requiredRules, ...passwordRules]"
            type="password"
            name="oldPassword"
            label="Old Password"
            placeholder="Email"
          />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <fg-input
            ref="newPasswordInput"
            v-model="user.newPassword"
            :rules="[...requiredRules, ...passwordRules, newPasswordValidator]"
            label="New Password"
            name="newPassword"
            type="password"
          />
        </div>
        <div class="col-md-6">
          <fg-input
            ref="newPasswordConfirmationInput"
            v-model="user.newPasswordConfirmation"
            :rules="[...requiredRules, ...passwordRules, newPasswordValidator]"
            label="New Password Confirmation"
            name="newPasswordConfirmation"
            type="password"
          />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <button type="submit" class="btn btn-info btn-fill float-right" @click.prevent="changePassword">
              Change password
            </button>
          </div>
        </div>
      </div>
    </v-form>

    <div class="clearfix" />
  </card>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import PasswordValidationMixin from '@/mixins/passwordValidationMixin';
import Card from '@/components/UIComponents/Cards/Card.vue';

export default {
  components: {
    Card,
  },
  mixins: [PasswordValidationMixin],
  data() {
    return {
      user: {
        oldPassword: '',
        newPassword: '',
        newPasswordConfirmation: '',
      },
    };
  },
  computed: {
    ...mapGetters({
      userDetails: 'user/userDetails',
    }),
  },
  methods: {
    ...mapActions({
      updateDetails: 'user/updateDetails',
      changeUserPassword: 'user/changePassword',
      addNotification: 'application/addNotification',
    }),
    changeDetails() {
      this.updateDetails(this.userDetails)
        .then(() => {
          this.addNotification({
            show: true,
            text: 'Details changed',
          });
        })
        .catch(() => {
          this.addNotification({
            show: true,
            text: 'Failed to change details!!!',
          });
        });
    },
    changePassword() {
      this.changeUserPassword(Object.assign({}, this.user, {
        newPassword_confirmation: this.user.newPasswordConfirmation,
      }))
        .then(() => {
          this.addNotification({
            show: true,
            text: 'Password changed',
          });
        })
        .catch(() => {
          this.addNotification({
            show: true,
            text: 'Failed to change password!!!',
          });
        });
    },
    newPasswordValidator() {
      return (this.user.newPasswordConfirmation === this.user.newPassword) || 'New password is not confirmed';
    },
  },
};
</script>
<style>

hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}

</style>
