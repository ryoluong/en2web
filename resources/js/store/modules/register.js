import axios from '@/js/axios';

const actions = {
  async verify({ dispatch }, payload) {
    let user;
    await axios
      .post(`/register/verify`, payload)
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
  async register({ dispatch }, payload) {
    let ok;
    await axios
      .post(`/register`, payload)
      .then(() => {
        ok = true;
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
        ok = false;
      });
    return ok;
  },
};

export default {
  namespaced: true,
  actions,
};
