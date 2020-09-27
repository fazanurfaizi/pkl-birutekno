require('./bootstrap');

import Vue from 'vue';
import axios from 'axios';
import Vuetify from 'vuetify';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import ElementUI from 'element-ui';

import App from '@/components/App.vue';
import router from '@/router';
import store from '@/store';
import can from '@/helpers/can';

import 'bootstrap/dist/css/bootstrap.min.css';

// import '@/assets/style/main.css'
// import '@/assets/style/util.css'

Vue.config.productionTip = false;
Vue.prototype.$can = can;

Vue.use(ElementUI, {
    size: 'medium'
});

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuetify);

axios.get('/api/role-permissions').then((response) => {
    Vue.prototype.$constants = response.data;
})

new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify(),
    render: h => h(App)
});