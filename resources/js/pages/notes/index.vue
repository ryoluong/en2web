<template>
  <div v-scroll="onScroll">
    <v-container v-if="!loading" :ref="notes" :style="style" class="px-0">
      <NoteCard
        v-for="(n, i) in displayNotes"
        :key="i"
        :note="n"
        class="mx-auto mt-10 my-12"
      />
    </v-container>
    <v-container v-if="loading || fetching" class="px-0">
      <v-skeleton-loader
        v-for="i in 3"
        :key="i"
        class="mx-auto my-8"
        type="card-avatar"
        elevation="4"
        max-width="500"
      />
    </v-container>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import NoteCard from '@/components/NoteCard.vue';
export default {
  components: { NoteCard },
  data: () => ({
    loading: true,
    fetching: true,
    offset: 0,
  }),
  computed: {
    ...mapState('note', ['notes', 'currentPage', 'lastPage', 'to']),
    params() {
      return {
        page: this.currentPage + 1,
      };
    },
    needFetch() {
      return !this.fetching && this.currentPage != this.lastPage;
    },
    threshold() {
      return document.body.clientHeight - this.noteHeight;
    },
    headerHeight() {
      return document.getElementById('header').clientHeight + 40; // header + containerのpadding
    },
    noteHeight() {
      return 352;
    },
    firstIndex() {
      const res =
        Math.floor((this.offset - this.headerHeight) / this.noteHeight) - 2;
      return res > 0 ? res : 0;
    },
    lastIndex() {
      return this.firstIndex + 8;
    },
    displayNotes() {
      const _this = this;
      return this.notes.filter((n, i) => {
        return i >= _this.firstIndex && i <= _this.lastIndex;
      });
    },
    style() {
      return {
        paddingTop: this.noteHeight * this.firstIndex + 'px',
        paddingBottom:
          this.noteHeight * (this.notes.length - this.lastIndex - 1) + 'px',
      };
    },
  },
  async created() {
    await this.fetchNotes();
    this.loading = false;
  },
  methods: {
    async fetchNotes() {
      this.fetching = true;
      await this.$store.dispatch('note/index', this.params);
      this.fetching = false;
    },
    onScroll() {
      this.offset = window.pageYOffset;
      if (this.needFetch && this.lastIndex === this.to) {
        this.fetchNotes();
      }
    },
  },
};
</script>
