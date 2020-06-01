/* eslint-disable no-unused-vars */
import Vue from 'vue';

import axios from './axios';
Vue.prototype.$http = axios;

import Vue2TouchEvents from 'vue2-touch-events';
Vue.use(Vue2TouchEvents);

import router from './router';
import store from './store';
import vuetify from './vuetify';

import './validate';

import App from './App.vue';

// import common style
import '../sass/common.scss';

export default new Vue({
  el: '#app',
  router,
  store,
  vuetify,
  components: { App },
  template: '<App />',
});
