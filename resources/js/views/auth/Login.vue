<template>
    <section class="login-block">
        <div class="container">
            <div class="row">
                <div class="col-md-4 login-sec">
                    <h2 class="text-center">Login Now</h2>
                    <v-form class="login-form" ref="loginForm">
                        <div class="form-group">
                            <label for="username" class="text-uppercase">Username</label>
                            <input type="text" class="form-control" label="Username" name="username" v-model="user.username">
                        </div>

                        <div class="form-group">
                            <label for="password" class="text-uppercase">Password</label>
                            <input :rules="passwordRules" id="password"
                                label="Password" name="password" type="password" 
                                v-model="user.password" class="form-control">
                        </div>

                        <div class="form-check">
                            <button type="button" @click="loginUser" class="btn btn-login float-right">Submit</button>
                        </div>

                    </v-form>                    
                </div>
                <div class="col-md-8 banner-sec">
                    <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="banner-text">
                            <h2>This is Heaven</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                        </div>	
                    </div>                    
                </div>
            </div>
        </div>
    </section>    
</template>

<script>
    import { mapActions } from 'vuex';
    import PasswordValidationMixin from '@/mixins/passwordValidationMixin';

    export default {
        name: "Login",
        mixins: [PasswordValidationMixin],
        data() {
            return {
                user: {
                    username: '',
                    password: ''
                },
            }
        },
        methods: {
            ...mapActions({
                login: 'user/loginUser',
                loginGithubAction: 'user/loginGithub',
                addNotification: 'application/addNotification'
            }),
            loginUser() {
                if (this.$refs.loginForm.validate()) {
                    this.login(this.user)
                        .then(() => {
                            this.addNotification({
                                show: true,
                                text: 'Welcome'
                            }).then(() => {
                                this.$router.push({name: 'dashboard'});
                            })
                        })
                        .catch(() => {
                            this.addNotification({
                                show: true,
                                text: 'Failed to login!!!'
                            })
                        })
                }
            },
            loginGithub() {
                this.loginGithubAction().then((resp) => {
                    if (resp.data.url) {
                        window.location.href = resp.data.url
                    }
                })
            }
        }
    }
</script>

<style >
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