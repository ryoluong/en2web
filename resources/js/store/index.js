import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import meta from './modules/meta';
import snackbar from './modules/snackbar';
import note from './modules/note';
import user from './modules/user';
import country from './modules/country';
import register from './modules/register';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    referrer: null,
  },
  modules: {
    auth,
    register,
    meta,
    snackbar,
    note,
    user,
    country,
  },
});

export default store;
