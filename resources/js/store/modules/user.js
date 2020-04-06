import axios from '@/js/axios';

const state = {
  users: [],
  showBy: 0,
  groupBy: 'department',
  search: '',
  noteTabUserId: 0,
};
const actions = {
  async index({ commit, dispatch }, params) {
    if (state.users.length == 0) {
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
    }
    return state.users;
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
  async update({ dispatch }, payload) {
    let user;
    await axios
      .patch(`/users/update`, payload)
      .then(res => {
        user = res.data;
        dispatch(
          'snackbar/show',
          {
            message: 'プロフィールが更新されました！',
          },
          { root: true },
        );
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
  setNoteTabUserId(state, userId) {
    state.noteTabUserId = userId;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
