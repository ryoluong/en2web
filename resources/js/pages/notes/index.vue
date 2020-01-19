<template>
  <div v-scroll="onScroll">
    <v-container v-if="!loading" ref="container" :style="style" class="px-0">
      <NoteCard
        v-for="n in displayNotes"
        :key="n.id"
        :note="n"
        class="mx-auto my-12"
      />
    </v-container>
    <v-container v-if="loading || fetching" class="px-0">
      <v-skeleton-loader
        v-for="i in 2"
        :key="i"
        class="mx-auto my-12"
        type="list-item-avatar,image,list-item-two-line"
        max-width="500"
      />
    </v-container>
  </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex';
import NoteCard from '@/components/NoteCard.vue';
export default {
  components: { NoteCard },
  data: () => ({
    loading: true,
    fetching: false,
    offset: 0,
  }),
  computed: {
    ...mapState('note', [
      'notes',
      'currentPage',
      'lastPage',
      'to',
      'savedOffset',
      'category',
    ]),
    categoryIds() {
      return [0, 6, 2, 4, 3, 5, 1];
    },
    params() {
      return {
        page: this.currentPage + 1,
        category_id: this.categoryIds[this.category],
      };
    },
    needFetch() {
      return !this.fetching && this.currentPage != this.lastPage;
    },
    headerHeight() {
      return document.getElementById('header').clientHeight + 48 * 2; // header + containerのpadding
    },
    newHeaderHeight() {
      return this.$refs.container
        ? 0
        : this.$refs.container.getBoundingClientRect().top;
    },
    noteHeight() {
      return 400;
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
        n.index = i;
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
  watch: {
    category: async function() {
      this.loading = true;
      this.clearNotes();
      this.scrollTop();
      await this.fetchNotes();
      this.loading = false;
    },
  },
  async created() {
    if (this.currentPage === 0) {
      await this.fetchNotes();
    }
    this.loading = false;
  },
  beforeDestroy() {
    this.saveOffset(this.offset);
  },
  methods: {
    ...mapMutations('note', ['saveOffset', 'clearNotes', 'updateCategory']),
    async fetchNotes() {
      this.fetching = true;
      await this.$store.dispatch('note/index', this.params);
      this.fetching = false;
    },
    onScroll() {
      this.offset = window.pageYOffset;
      if (this.needFetch && this.lastIndex >= this.to) {
        this.fetchNotes();
      }
    },
    scrollTop() {
      this.$vuetify.goTo(0, { duration: 0 });
    },
  },
};
</script>
