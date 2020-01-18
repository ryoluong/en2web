const state = {
  title: '',
};

const actions = {
  setTitle({ commit }, title) {
    commit('setTitle', title);
  },
};

const mutations = {
  setTitle(state, title) {
    state.title = title;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
