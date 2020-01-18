<template>
  <div>
    <v-app-bar
      id="header"
      app
      color="indigo lighten-1"
      dark
      elevation="3"
      hide-on-scroll
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>{{ title }}</v-toolbar-title>
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
    ...mapState('meta', ['title']),
    ...mapState('auth', ['isAuth']),
  },
};
</script>
