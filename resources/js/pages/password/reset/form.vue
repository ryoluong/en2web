<template>
  <FormCard title="Set New Password" class="max-width">
    <div class="px-2 px-sm-4">
      <ValidationObserver ref="observer" v-slot="{ passes }">
        <ValidationProvider
          v-slot="{ errors }"
          name="Email"
          rules="required|email"
        >
          <v-text-field
            v-model="email"
            :error-messages="errors"
            label="Email"
            type="email"
            :disabled="submitting"
          />
        </ValidationProvider>
        <ValidationProvider
          v-slot="{ errors }"
          name="Password"
          :rules="{
            required: true,
            min: 8,
            max: 50,
            regex: /^[a-zA-Z0-9!-/:-@¥[-`{-~]+$/,
          }"
          vid="password"
        >
          <v-text-field
            v-model="password"
            class="mb-2"
            :error-messages="errors"
            label="Password"
            type="password"
            required
            :disabled="submitting"
          />
        </ValidationProvider>
        <ValidationProvider
          v-slot="{ errors }"
          name="Password Confirmation"
          rules="required|confirmed:password"
          vid="confirmation"
        >
          <v-text-field
            v-model="confirmation"
            class="mb-2"
            :error-messages="errors"
            label="Confirm Password"
            type="password"
            required
            :disabled="submitting"
          />
        </ValidationProvider>
        <v-btn
          class="white--text mt-2 d-block"
          min-width="100px"
          :loading="submitting"
          color="blue-grey"
          large
          @click="passes(submit)"
        >
          Submit
        </v-btn>
      </ValidationObserver>
    </div>
  </FormCard>
</template>
<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import { mapActions } from 'vuex';
import FormCard from '@/js/components/FormCard.vue';
export default {
  components: {
    FormCard,
    ValidationObserver,
    ValidationProvider,
  },
  data: () => ({
    email: '',
    password: '',
    confirmation: '',
    submitting: false,
  }),
  computed: {
    params() {
      return {
        email: this.email,
        password: this.password,
        password_confirmation: this.confirmation,
        token: this.$route.params.token,
      };
    },
  },
  methods: {
    ...mapActions('snackbar', { showSnackbar: 'show' }),
    ...mapActions('auth', ['reset']),
    async submit() {
      this.submitting = true;
      const ok = await this.reset(this.params);
      if (ok) {
        this.showSnackbar({
          type: 'success',
          message: 'パスワードが正常に更新されました。',
        });
        this.$router.push('/login');
      }
      this.submitting = false;
    },
  },
};
</script>
