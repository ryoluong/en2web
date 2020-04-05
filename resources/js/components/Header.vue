<template>
  <div>
    <v-app-bar id="header" app color="indigo lighten-1" dark hide-on-scroll>
      <v-btn v-if="$route.meta.header === 'back'" icon @click="handelGoBack()">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-app-bar-nav-icon v-else @click.stop="drawer = !drawer" />
      <v-toolbar-title>{{ title }}</v-toolbar-title>
      <v-spacer />
      <v-fade-transition group>
        <v-btn
          v-for="action in actions"
          :key="action.icon"
          :to="action.to"
          icon
        >
          <v-icon>
            {{ action.icon }}
          </v-icon>
        </v-btn>
      </v-fade-transition>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app>
      <Nav v-if="isAuth" />
      <NavGuest v-else />
    </v-navigation-drawer>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import NavGuest from './NavGuest.vue';
import Nav from './Nav.vue';
export default {
  components: { NavGuest, Nav },
  data: () => ({
    drawer: false,
  }),
  computed: {
    ...mapState('meta', ['title', 'actions']),
    ...mapState('auth', ['isAuth']),
  },
  methods: {
    handelGoBack() {
      this.$router.go(-1);
    },
  },
};
</script>
