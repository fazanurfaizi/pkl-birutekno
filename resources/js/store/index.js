import Vue from 'vue';
import Vuex from 'vuex';

import user from './modules/user';
import application from './modules/application';
import categories from './modules/categories';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    application,
    user,
    categories,
  },
});
