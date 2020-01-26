<template>
  <div>
    <v-app-bar id="header" app color="indigo lighten-1" dark hide-on-scroll>
      <v-btn v-if="$route.meta.header === 'back'" icon @click="$router.go(-1)">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-app-bar-nav-icon v-else @click.stop="drawer = !drawer" />
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
