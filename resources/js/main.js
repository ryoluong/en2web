/* eslint-disable no-unused-vars */
import Vue from 'vue';

import axios from './axios';
Vue.prototype.$http = axios;

import router from './router';
import store from './store';
import vuetify from './vuetify';

import './validate';

// import { VLazyImagePlugin } from 'v-lazy-image';
// Vue.use(VLazyImagePlugin);

import App from './App.vue';

export default new Vue({
  el: '#app',
  router,
  store,
  vuetify,
  components: { App },
  template: '<App />'
});
