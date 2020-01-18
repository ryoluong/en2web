import axios from '@/axios';
const state = {
  notes: [],
  currentPage: 0,
  lastPage: 0,
  to: 0,
};

const actions = {
  async index({ commit, dispatch }, params) {
    await axios
      .get('/notes', {
        params: params,
      })
      .then(res => {
        commit('indexSuccess', res.data);
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          {
            message: 'エラーが発生しました',
            type: 'error',
          },
          { root: true },
        );
      });
  },
};

const mutations = {
  indexSuccess(state, payload) {
    state.notes = state.notes.concat(payload.data);
    state.currentPage = payload.current_page;
    state.lastPage = payload.last_page;
    state.to = payload.to;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
