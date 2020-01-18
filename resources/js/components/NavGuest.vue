<template>
  <v-list dense>
    <v-list-item
      v-for="i in items"
      :key="i.name"
      link
      :to="i.to"
      color="indigo"
      @click="notice(i.to)"
    >
      <v-list-item-action>
        <v-icon>{{ i.icon }}</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>{{ i.name }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>
<script>
import { mapActions } from 'vuex';
export default {
  data: () => ({
    items: [
      {
        to: '/login',
        icon: 'mdi-account-key',
        name: 'Login',
      },
      {
        to: null,
        icon: 'mdi-account-plus',
        name: 'Register',
      },
      {
        to: null,
        icon: 'mdi-account-question',
        name: 'Reset Password',
      },
    ],
  }),
  methods: {
    ...mapActions('snackbar', ['show']),
    ...mapActions('auth', ['postLogoutRequest']),
    notice(to) {
      if (!to) {
        this.show({ message: '現在準備中です', type: 'accent' });
      }
    },
    async logout() {
      if (!this.loading) {
        this.loading = true;
        const status = await this.postLogoutRequest();
        if (status == 200) {
          this.$router.push('/login');
          this.show({ message: 'ログアウトしました', type: 'accent' });
        } else {
          this.show({ message: 'エラーが発生しました', type: 'error' });
        }
        this.loading = false;
      }
    },
  },
};
</script>
