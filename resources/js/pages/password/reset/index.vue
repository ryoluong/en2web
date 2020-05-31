<template>
  <FormCard
    title="Send Password Reset Link"
    class="max-width"
    :show-progress="submitting"
  >
    <form v-if="!submitted" @submit.prevent="handleSubmit">
      <v-text-field
        v-model="email"
        class="px-2"
        prepend-icon="mdi-email"
        placeholder="example@en2ynu.com"
        required
        :disabled="submitting"
        type="email"
      />
      <v-btn
        class="white--text ml-3 mt-2 d-block"
        min-width="100px"
        :loading="submitting"
        color="blue-grey"
        type="submit"
        large
      >
        Submit
      </v-btn>
    </form>
    <div v-else class="px-2 pt-6">
      <p class="grey--text text--darken-3">
        <span class="indigo--text font-weight-medium">{{ email }}</span>
        宛にパスワード再設定用リンクを送信いたしました。
      </p>
      <p class="grey--text text--darken-3">
        メールが届かない場合、登録したメールアドレスではない、もしくはメールアドレスが間違っている可能性があります。
      </p>
    </div>
  </FormCard>
</template>
<script>
import { mapActions } from 'vuex';
import FormCard from '@/js/components/FormCard.vue';
export default {
  components: {
    FormCard,
  },
  data: () => ({
    email: '',
    submitting: false,
    submitted: false,
  }),
  computed: {
    params() {
      return {
        email: this.email,
      };
    },
  },
  methods: {
    ...mapActions('auth', ['remind']),
    async handleSubmit() {
      const date = new Date();
      const startTime = date.getTime();
      this.submitting = true;
      const ok = await this.remind(this.params);
      const endTime = date.getTime();
      const elapsed = endTime - startTime;
      if (elapsed < 1) {
        await new Promise(r => setTimeout(r, (1 - elapsed) * 1000));
      }
      if (ok) {
        this.submitted = true;
      }
      this.submitting = false;
    },
  },
};
</script>
