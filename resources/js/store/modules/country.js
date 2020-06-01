import axios from '@/js/axios';
const state = {
  countries: [],
};
const actions = {
  async index({ commit, dispatch }) {
    if (state.countries.length == 0) {
      await axios
        .get('/countries')
        .then(res => {
          commit('setCountries', res.data);
        })
        .catch(() => {
          dispatch(
            'snackbar/show',
            { message: 'エラーが発生しました', type: 'error' },
            { root: true },
          );
        });
    }
    return state.countries;
  },
};
const mutations = {
  setCountries(state, countries) {
    state.countries = countries;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
