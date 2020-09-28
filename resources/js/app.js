require('./bootstrap');

import Vue from 'vue';
import axios from 'axios';
import Vuetify from 'vuetify';
import VueSwal from 'vue-swal';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import App from '@/components/App.vue';
import router from '@/router';
import store from '@/store';
import can from '@/helpers/can';

import 'vue-phone-number-input/dist/vue-phone-number-input.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import LightBootstrap from '@/plugins/light-bootstrap-main.js';

Vue.config.productionTip = false;
Vue.prototype.$can = can;

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuetify);
Vue.use(LightBootstrap);
Vue.use(VueSwal);

axios.get('/api/role-permissions').then((response) => {
  Vue.prototype.$constants = response.data;
});

new Vue({
  el: '#app',
  router,
  store,
  vuetify: new Vuetify(),
  render: h => h(App),
});
