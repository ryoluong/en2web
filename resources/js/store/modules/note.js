import axios from '@/js/axios';

const state = {
  notes: [],
  conditions: [],
  currentPage: 0,
  lastPage: 0,
  to: 0,
  savedOffset: 0,
  savedFullPath: '',
  favNotes: [],
  categories: [],
  tags: [],
};

const actions = {
  async index({ commit, dispatch }, params) {
    await axios
      .get('/notes', {
        params: params,
      })
      .then((res) => {
        commit('indexSuccess', res.data);
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          { message: 'エラーが発生しました', type: 'error' },
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
          { message: 'エラーが発生しました', type: 'error' },
          { root: true },
        );
      });
  },
  async get({ dispatch }, id) {
    let note;
    await axios
      .get(`/notes/${id}`)
      .then((res) => {
        note = res.data;
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          { message: 'エラーが発生しました', type: 'error' },
          { root: true },
        );
      });
    return note;
  },
  async getForEdit({ dispatch }, id) {
    let note;
    await axios
      .get(`/notes/${id}?for_edit=1`)
      .then((res) => {
        note = res.data;
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          { message: 'エラーが発生しました', type: 'error' },
          { root: true },
        );
      });
    return note;
  },
  async create({ dispatch }, payload) {
    let note = null;
    const formData = new FormData();
    Object.keys(payload).forEach((key) => {
      if (
        key === 'files' ||
        key === 'tags' ||
        key === 'countries' ||
        key === 'delete_photo_ids'
      ) {
        if (payload[key].length > 0) {
          payload[key].forEach((f, i) => {
            formData.append(`${key}[${i}]`, f);
          });
        }
      } else {
        formData.append(key, payload[key]);
      }
    });
    const config = {
      headers: {
        'content-type': 'multipart/form-data',
      },
    };
    await axios
      .post(`/notes`, formData, config)
      .then((res) => {
        note = res.data;
        dispatch(
          'snackbar/show',
          {
            message: 'ノートが作成されました！',
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
    return note;
  },
  async update({ commit, dispatch }, payload) {
    let note = null;
    const formData = new FormData();
    formData.append('_method', 'PUT');
    Object.keys(payload).forEach((key) => {
      if (
        key === 'files' ||
        key === 'tags' ||
        key === 'countries' ||
        key === 'delete_photo_ids'
      ) {
        if (payload[key].length > 0) {
          payload[key].forEach((f, i) => {
            formData.append(`${key}[${i}]`, f);
          });
        }
      } else {
        formData.append(key, payload[key]);
      }
    });
    const config = {
      headers: {
        'content-type': 'multipart/form-data',
      },
    };
    await axios
      .post(`/notes/${payload.note_id}`, formData, config)
      .then((res) => {
        note = res.data;
        commit('updateSuccess', note);
        dispatch(
          'snackbar/show',
          { message: 'ノートが更新されました！' },
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
    return note;
  },
  async delete({ commit, dispatch }, id) {
    let ok = false;
    await axios
      .delete(`/notes/${id}`)
      .then((res) => {
        ok = res.data.ok;
        commit('deleteSuccess', id);
        dispatch(
          'snackbar/show',
          {
            message: 'ノートが削除されました。',
          },
          { root: true },
        );
      })
      .catch(() => {
        dispatch(
          'snackbar/show',
          {
            message: 'エラーが発生しました。ノートの削除に失敗しました。',
            type: 'error',
          },
          { root: true },
        );
      });
    return ok;
  },
  async categories({ commit, dispatch }) {
    if (state.categories.length === 0) {
      await axios
        .get('/notes/categories')
        .then((res) => {
          commit('setCategories', res.data);
        })
        .catch(() => [
          dispatch(
            'snackbar/show',
            { message: 'エラーが発生しました', type: 'error' },
            { root: true },
          ),
        ]);
    }
    return state.categories;
  },
  async tags({ commit, dispatch }) {
    if (state.tags.length === 0) {
      await axios
        .get('/notes/tags')
        .then((res) => {
          commit('setTags', res.data);
        })
        .catch(() => [
          dispatch(
            'snackbar/show',
            { message: 'エラーが発生しました', type: 'error' },
            { root: true },
          ),
        ]);
    }
    return state.tags;
  },
};

const mutations = {
  clearNotes(state) {
    state.currentPage = 0;
    state.lastPage = 0;
    state.to = 0;
    state.notes = [];
    state.conditions = [];
  },
  saveOffset(state, offset) {
    state.savedOffset = offset;
  },
  saveFullPath(state, fullPath) {
    state.savedFullPath = fullPath;
  },
  setFavNotes(state, favNotes) {
    state.favNotes = favNotes;
  },
  setCategories(state, categories) {
    state.categories = categories;
  },
  setTags(state, tags) {
    state.tags = tags;
  },
  indexSuccess(state, payload) {
    state.notes = state.notes.concat(payload.data);
    state.conditions = payload.conditions;
    state.currentPage = payload.current_page;
    state.lastPage = payload.last_page;
    state.to = payload.to;
  },
  updateSuccess(state, note) {
    state.notes.some((n, i) => {
      if (n.id == note.id) {
        state.notes[i] = note;
      }
    });
  },
  deleteSuccess(state, id) {
    state.notes.some((note, i) => {
      if (note.id == id) {
        state.notes.splice(i, 1);
      }
    });
  },
  fav(state, noteId) {
    if (state.favNotes.indexOf(noteId) === -1) {
      state.favNotes.push(noteId);
      state.notes.some((note) => {
        if (note.id === noteId) note.fav_users_count++;
      });
    } else {
      state.favNotes.some((v, i) => {
        if (v === noteId) state.favNotes.splice(i, 1);
      });
      state.notes.some((note) => {
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
