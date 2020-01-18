import axios from '@/axios';
import router from '@/router';
const state = {
  isAuth: false,
  user: null,
};

const actions = {
  async login({ commit, dispatch }, payload) {
    await axios
      .post('/login', payload)
      .then(res => {
        commit('authenticated');
        commit('setUser', res.data.user);
        localStorage.setItem('access_token', res.data.access_token);
        router.push('/notes');
        dispatch(
          'snackbar/show',
          { message: 'ログインしました' },
          { root: true },
        );
      })
      .catch(err => {
        if (err.response.status === 401) {
          dispatch(
            'snackbar/show',
            {
              message: 'メールアドレスまたはパスワードが違います',
              type: 'error',
            },
            { root: true },
          );
        } else {
          dispatch(
            'snackbar/show',
            {
              message: 'エラーが発生しました',
              type: 'error',
            },
            { root: true },
          );
        }
      });
  },
  async refresh({ commit }) {
    await axios
      .post('/refresh', {})
      .then(res => {
        commit('authenticated');
        commit('setUser', res.data.user);
        localStorage.setItem('access_token', res.data.access_token);
      })
      .catch(() => {
        localStorage.removeItem('access_token');
      });
  },
  async logout({ commit, dispatch }) {
    dispatch(
      'snackbar/show',
      { message: 'ログアウト中...', type: 'accent' },
      { root: true },
    );
    await axios.post('/logout').finally(() => {
      commit('unauthenticated');
      commit('setUser', null);
      localStorage.removeItem('access_token');
      router.push('/login');
      dispatch(
        'snackbar/show',
        { message: 'ログアウトしました', type: 'accent' },
        { root: true },
      );
    });
  },
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  authenticated(state) {
    state.isAuth = true;
  },
  unauthenticated(state) {
    state.isAuth = false;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
