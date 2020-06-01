<template>
  <div>
    <v-card class="mx-2 mx-sm-auto mt-3 mt-lg-6 mb-6" max-width="450px">
      <v-card-subtitle class="error subtitle-1 white--text">
        Delete Confirm
      </v-card-subtitle>
      <v-progress-linear
        v-if="loading || submitting"
        indeterminate
        color="red darken-1"
      />
      <div v-if="!loading" class="pb-6">
        <p class="d-block py-4 mx-3 mb-0">
          以下のノートを削除します。本当によろしいですか？
        </p>
        <v-btn
          class="white--text mx-3 mt-1 mt-md-3 d-block"
          width="120px"
          :loading="submitting"
          color="error"
          large
          @click="confirmDelete"
        >
          Delete
        </v-btn>
      </div>
    </v-card>
    <NoteCard v-if="!loading" class="mx-auto" :note="note" :hide-fav="true" />
  </div>
</template>
<script>
import { mapActions } from 'vuex';
import NoteCard from '@/js/components/notes/NoteCard.vue';
export default {
  components: { NoteCard },
  data: () => ({
    loading: true,
    submitting: false,
    note: null,
  }),
  async created() {
    this.note = await this.get(this.$route.params.id);
    if (
      this.note.user_id !== this.$store.state.auth.user.id &&
      !this.$store.state.auth.user.isAdmin
    ) {
      this.$store.dispatch('snackbar/show', {
        message: '権限がありません。',
        type: 'error',
      });
      this.$router.push('/notes');
    }
    this.loading = false;
  },
  methods: {
    ...mapActions('note', ['get', 'delete']),
    async confirmDelete() {
      this.submitting = true;
      const ok = await this.delete(this.$route.params.id);
      if (ok) {
        this.$router.go(-2);
      }
      this.submitting = false;
    },
  },
};
</script>
