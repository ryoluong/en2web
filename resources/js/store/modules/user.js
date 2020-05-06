import axios from '@/js/axios';

const state = {
  users: [],
  displayUserIds: [],
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
          { message: 'エラーが発生しました', type: 'error' },
          { root: true },
        );
      });
    return user;
  },

  async upload({ dispatch }, payload) {
    let imagePath;
    const formData = new FormData();
    formData.append('file', payload['file']);
    formData.append('type', payload['type']);
    const config = {
      headers: { 'content-type': 'multipart/form-data' },
    };
    await axios
      .post(`/users/upload`, formData, config)
      .then(res => {
        imagePath = res.data.path;
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          { message: 'エラーが発生しました', type: 'error' },
          { root: true },
        );
      });
    return imagePath;
  },

  async saveIcon({ dispatch, commit }, payload) {
    let user;
    await axios
      .post(`/users/icon`, payload)
      .then(res => {
        user = res.data;
        commit('auth/setUser', user, { root: true });
        dispatch(
          'snackbar/show',
          { message: 'アイコンが更新されました！' },
          { root: true },
        );
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          { message: 'エラーが発生しました', type: 'error' },
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
  setDisplayUserIds(state, userIds) {
    state.displayUserIds = userIds;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
