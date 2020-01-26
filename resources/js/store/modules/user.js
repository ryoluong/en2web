import axios from '@/axios';
const actions = {
  async index({ dispatch }, params) {
    let users;
    await axios
      .get('/users', {
        params: params,
      })
      .then(res => {
        users = res.data;
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
    return users;
  },
};

export default {
  namespaced: true,
  actions,
};
