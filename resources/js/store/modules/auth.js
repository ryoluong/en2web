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
        localStorage.setItem('access_token', res.data.access_token);
        router.push('/notes');
        dispatch('me');
        dispatch(
          'snackbar/show',
          { message: 'ログインしました' },
          { root: true },
        );
      })
      .catch(err => {
        let message;
        switch (err.response.status) {
          case 401:
            message = 'メールアドレスまたはパスワードが違います';
            break;
          case 429:
            message = `一定回数以上ログインに失敗しました。${err.response.data.remain_seconds}秒後に再度お試しください。`;
            break;
          default:
            message = 'エラーが発生しました';
        }
        dispatch(
          'snackbar/show',
          { message: message, type: 'error' },
          { root: true },
        );
      });
  },
  async refresh({ commit, dispatch }) {
    await axios
      .post('/refresh', {})
      .then(res => {
        commit('authenticated');
        localStorage.setItem('access_token', res.data.access_token);
        dispatch('me');
      })
      .catch(() => {
        commit('unauthenticated');
        commit('setUser', null);
        localStorage.removeItem('access_token');
      });
  },
  async me({ commit }) {
    await axios.get('/me').then(res => {
      commit('setUser', res.data.user);
      commit('note/setFavNotes', res.data.favNotes, { root: true });
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
