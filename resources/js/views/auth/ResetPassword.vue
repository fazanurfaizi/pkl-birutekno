<template>
  <section class="login-block">
    <div class="container">
      <div class="row">
        <div class="col-md-5 login-sec">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="text-center">
                <h3><i class="fa fa-lock fa-4x" /></h3>
                <h2 class="text-center">Forgot Password?</h2>
                <p>You can reset your password here.</p>
                <div class="panel-body">
                  <v-form id="reset-password-form" ref="resetPasswordForm" role="form" autocomplete="off" class="form">
                    <div class="form-group">
                      <label for="email" class="text-uppercase">Email</label>
                      <input
                        v-model="user.email"
                        class="form-control"
                        :rules="[...requiredRules, ...emailRules]"
                        label="Email"
                        name="email"
                        type="email"
                      >
                    </div>

                    <div class="form-group">
                      <label for="password" class="text-uppercase">Password</label>
                      <input
                        id="password"
                        v-model="user.password"
                        label="Password"
                        name="password"
                        :rules="[...requiredRules, ...passwordRules, passwordValidator]"
                        type="password"
                        class="form-control"
                      >
                    </div>

                    <div class="form-group">
                      <label for="password" class="text-uppercase">Password</label>
                      <input
                        id="password_confirmation"
                        v-model="user.password_confirmation"
                        label="Password Confirmation"
                        :rules="[...requiredRules, ...passwordRules, passwordValidator]"
                        name="password_confirmation"
                        type="password"
                        class="form-control"
                      >
                    </div>

                    <div class="form-group">
                      <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="button" @click="sendResetPassword">
                    </div>
                  </v-form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-7 banner-sec">
          <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide" style="background-repeat: no-repeat;">
          <div class="carousel-caption d-none d-md-block">
            <div class="banner-text">
              <h2>This is Heaven</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
            </div>
          </div>
        </div>
        <router-link :to="{name: 'login'}">Login</router-link>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions } from 'vuex';
import PasswordValidationMixin from '@/mixins/passwordValidationMixin';
export default {
  name: 'ResetPassword',
  mixins: [PasswordValidationMixin],
  data() {
    return {
      user: {
        email: '',
        password: '',
        password_confirmation: '',
      },
    };
  },
  methods: {
    ...mapActions({
      resetPassword: 'user/resetPassword',
      addNotification: 'application/addNotification',
    }),
    sendResetPassword() {
      if (this.$refs.resetPasswordForm.validate()) {
        const token = this.$route.query.token;
        this.resetPassword({ ...this.user, token })
          .then(() => {
            this.addNotification({
              text: 'Password changed!',
              show: true,
            }).then(() => {
              this.$router.push({ name: 'login' });
            });
          }).catch(() => {
            this.addNotification({
              text: 'Failed to change password!',
              show: true,
            });
          });
      }
    },
    passwordValidator() {
      return (this.user.password_confirmation === this.user.password) || 'Password is not confirmed';
    },
  },
};
</script>

<style scoped>
.login-block {
    background: #DE6262;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to bottom, #FFB88C, #DE6262);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to bottom, #FFB88C, #DE6262); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    float: left;
    width: 100%;
    padding : 50px 0;
}

.banner-sec {
    background:url(https://static.pexels.com/photos/33972/pexels-photo.jpg)  no-repeat left bottom;
    background-size:cover; min-height:500px;
    border-radius: 0 10px 10px 0;
    padding:0;
}

.container {
    background:#fff;
    border-radius: 10px;
    box-shadow: 15px 20px 0px rgba(0,0,0,0.1);
}

.carousel-inner {
    border-radius: 0 10px 10px 0;
}

.carousel-caption {
    text-align:left;
    left: 5%;
}

.login-sec {
    padding: 50px 30px;
    position: relative;
}

.login-sec .copy-text {
    position: absolute;
    width: 80%;
    bottom: 20px;
    font-size: 13px;
    text-align: center;
}

.login-sec .copy-text i {
    color:#FEB58A;
}

.login-sec .copy-text a {
    color:#E36262;
}

.login-sec h2 {
    margin-bottom:30px;
    font-weight:800;
    font-size:30px;
    color: #DE6262;
}

.login-sec h2:after {
    content:" ";
    width:100px;
    height:5px;
    background:#FEB58A;
    display:block;
    margin-top:20px;
    border-radius:3px;
    margin-left:auto;
    margin-right:auto
}

.btn-login {
    background: #DE6262;
    color:#fff;
    font-weight:600;
}

.banner-text {
    width:70%;
    position:absolute;
    bottom:40px;
    padding-left:20px;
}

.banner-text h2 {
    color:#fff;
    font-weight:600;
}

.banner-text h2:after {
    content:" ";
    width:100px;
    height:5px;
    background:#FFF;
    display:block;
    margin-top:20px;
    border-radius:3px;
}

.banner-text p {
    color:#fff;
}
</style>
