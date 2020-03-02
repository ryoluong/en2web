import axios from '@/axios';

const state = {
  users: [],
  showBy: 0,
  groupBy: 'department',
  search: '',
};

const actions = {
  async index({ commit, dispatch }, params) {
    await axios
      .get('/users', {
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
  async get({ dispatch }, id) {
    let user;
    await axios
      .get(`/users/${id}`)
      .then(res => {
        user = res.data;
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
    return user;
  },
};

const mutations = {
  indexSuccess(state, users) {
    state.users = users;
  },
  updateShowBy(state, showBy) {
    state.showBy = showBy;
  },
  updateGroupBy(state, groupBy) {
    state.groupBy = groupBy;
  },
  updateSearch(state, search) {
    state.search = search;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
