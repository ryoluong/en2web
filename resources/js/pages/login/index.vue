<template>
  <v-container fluid>
    <v-row class="ma-auto" align="center" justify="center">
      <v-col class="pb-2 pt-8" cols="11" md="6" lg="3">
        <v-img
          class="ma-auto"
          contain
          src="/img/logo/transparent.png"
          position="center center"
        />
        <p
          class="subtitle-1 mt-3 text-center d-block grey--text text--darken-1"
        >
          A web platform for En2 members.
        </p>
      </v-col>
    </v-row>
    <v-row align="center" justify="center">
      <v-col cols="11" lg="3" class="pt-0">
        <validation-observer v-slot="{ passes }" slim>
          <v-form>
            <v-col cols="12" class="pa-0">
              <validation-provider
                v-slot="{ errors }"
                name="email"
                rules="required|email"
              >
                <v-text-field
                  v-model="email"
                  :error-messages="errors"
                  type="email"
                  label="Email"
                  prepend-icon="mdi-email"
                  color="indigo lighten-1"
                  required
                />
              </validation-provider>
              <validation-provider
                v-slot="{ errors }"
                name="password"
                rules="required"
              >
                <v-text-field
                  v-model="password"
                  type="password"
                  label="Password"
                  :error-messages="errors"
                  prepend-icon="mdi-key-variant"
                  color="indigo lighten-1"
                  required
                />
              </validation-provider>
              <v-col cols="12" class="mt-9 pa-0 d-flex">
                <v-btn
                  class="white--text mr-8"
                  :loading="loading"
                  :disabled="loading"
                  color="indigo lighten-1"
                  large
                  @click="passes(login)"
                >
                  Sign in
                </v-btn>
                <v-checkbox
                  v-model="remember"
                  class="ma-0 pt-3"
                  label="Remember me"
                  color="indigo lighten-1"
                />
              </v-col>
            </v-col>
          </v-form>
        </validation-observer>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import { mapState } from 'vuex';
export default {
  components: {
    ValidationObserver,
    ValidationProvider,
  },
  data: () => ({
    loading: false,
    email: '',
    password: '',
    remember: false,
  }),
  computed: {
    ...mapState('auth', ['isAuth']),
    postData() {
      return {
        email: this.email,
        password: this.password,
        remember: this.remember,
      };
    },
  },
  mounted() {
    if (this.isAuth) {
      this.$router.push('/notes');
    }
  },
  methods: {
    async login() {
      this.loading = true;
      await this.$store.dispatch('auth/login', this.postData);
      this.loading = false;
    },
  },
};
</script>
