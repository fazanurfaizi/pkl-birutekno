<template>
  <v-container
    class="fill-height"
    fluid
  >
    <v-row
      align="center"
      justify="center"
    >
      <v-col
        cols="12"
        md="4"
        sm="8"
      >
        <v-card class="elevation-12">
          <v-toolbar
            color="primary"
            dark
            flat
          >
            <v-toolbar-title>Details</v-toolbar-title>
            <v-spacer />
          </v-toolbar>
          <v-card-text>
            <p><strong>Name:</strong> {{ userDetails.name }}</p>
            <p><strong>Email:</strong> {{ userDetails.email }}</p>
            <p><strong>Joined:</strong> {{ userDetails.created_at }}</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row
      align="center"
      justify="center"
    >
      <v-col
        cols="12"
        md="4"
        sm="8"
      >
        <v-card class="elevation-12">
          <v-toolbar
            color="primary"
            dark
            flat
          >
            <v-toolbar-title>Change details</v-toolbar-title>
            <v-spacer />
          </v-toolbar>
          <v-card-text>
            <v-form ref="changeDetailsForm">
              <v-text-field
                v-model="userDetails.name"
                :rules="requiredRules"
                label="Name"
                name="name"
                type="text"
              />

            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn color="primary" @click="changeDetails">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row
      align="center"
      justify="center"
    >
      <v-col
        cols="12"
        md="4"
        sm="8"
      >
        <v-card class="elevation-12">
          <v-toolbar
            color="primary"
            dark
            flat
          >
            <v-toolbar-title>Change password</v-toolbar-title>
            <v-spacer />
          </v-toolbar>
          <v-card-text>
            <v-form ref="changePasswordForm">
              <v-text-field
                v-model="user.oldPassword"
                :rules="[...requiredRules, ...passwordRules]"
                label="Old Password"
                name="oldPassword"
                type="password"
              />
              <v-text-field
                ref="newPasswordInput"
                v-model="user.newPassword"
                :rules="[...requiredRules, ...passwordRules, newPasswordValidator]"
                label="New Password"
                name="newPassword"
                type="password"
              />
              <v-text-field
                ref="newPasswordConfirmationInput"
                v-model="user.newPasswordConfirmation"
                :rules="[...requiredRules, ...passwordRules, newPasswordValidator]"
                label="New Password Confirmation"
                name="newPasswordConfirmation"
                type="password"
              />

            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn color="primary" @click="changePassword">Change password</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import PasswordValidationMixin from '@/mixins/passwordValidationMixin';
export default {
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
      if (!this.$refs.changeDetailsForm.validate()) {
        return false;
      }
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
      if (!this.$refs.changePasswordForm.validate()) {
        return false;
      }
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
