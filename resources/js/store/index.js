import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import meta from './modules/meta';
import snackbar from './modules/snackbar';
import note from './modules/note';
import user from './modules/user';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    auth,
    meta,
    snackbar,
    note,
    user,
  },
});

export default store;
