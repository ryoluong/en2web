import axios from '@/js/axios';

const state = {
  notes: [],
  currentPage: 0,
  lastPage: 0,
  to: 0,
  savedOffset: 0,
  favNotes: [],
  category: 0,
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
  async fav({ commit, dispatch }, noteId) {
    commit('fav', noteId);
    await axios
      .put(`/notes/${noteId}/fav`)
      .then(() => {})
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
    let note;
    await axios
      .get(`/notes/${id}`)
      .then(res => {
        note = res.data;
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
    return note;
  },
};

const mutations = {
  clearNotes(state) {
    state.currentPage = 0;
    state.lastPage = 0;
    state.to = 0;
    state.notes = [];
  },
  updateCategory(state, category) {
    state.category = category;
  },
  saveOffset(state, offset) {
    state.savedOffset = offset;
  },
  setFavNotes(state, favNotes) {
    state.favNotes = favNotes;
  },
  indexSuccess(state, payload) {
    state.notes = state.notes.concat(payload.data);
    state.currentPage = payload.current_page;
    state.lastPage = payload.last_page;
    state.to = payload.to;
  },
  fav(state, noteId) {
    if (state.favNotes.indexOf(noteId) === -1) {
      state.favNotes.push(noteId);
      state.notes.some(note => {
        if (note.id === noteId) note.fav_users_count++;
      });
    } else {
      state.favNotes.some((v, i) => {
        if (v === noteId) state.favNotes.splice(i, 1);
      });
      state.notes.some(note => {
        if (note.id === noteId) note.fav_users_count--;
      });
    }
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};
