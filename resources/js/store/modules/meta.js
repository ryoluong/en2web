const state = {
  title: '',
  actions: [],
};

const actions = {
  setTitle({ commit }, title) {
    commit('setTitle', title);
  },
  setActions({ commit }, actions) {
    commit('setActions', actions);
  },
  addActions({ commit }, actions) {
    commit('addActions', actions);
  },
};

const mutations = {
  setTitle(state, title) {
    state.title = title;
  },
  setActions(state, actions) {
    state.actions = actions;
  },
  addActions(state, actions) {
    state.actions = actions.concat(state.actions);
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
