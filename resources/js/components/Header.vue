<template>
  <div>
    <v-app-bar id="header" app color="indigo lighten-1" dark hide-on-scroll>
      <v-btn v-if="$route.meta.header === 'back'" icon @click="$router.go(-1)">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-app-bar-nav-icon v-else @click.stop="drawer = !drawer" />
      <v-toolbar-title>{{ title }}</v-toolbar-title>
      <template v-if="this.$route.path === '/notes'" v-slot:extension>
        <v-tabs
          v-model="category"
          background-color="indigo lighten-1"
          dark
          show-arrows
        >
          <v-tab>
            ALL
          </v-tab>
          <v-tab>
            思考の共有
          </v-tab>
          <v-tab>
            語学学習
          </v-tab>
          <v-tab>
            就活・仕事
          </v-tab>
          <v-tab>
            奨学金
          </v-tab>
          <v-tab>
            本・記事
          </v-tab>
          <v-tab>
            月一報告
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app>
      <Nav v-if="isAuth" />
      <NavGuest v-else />
    </v-navigation-drawer>
  </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex';
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
    category: {
      get() {
        return this.$store.state.note.category;
      },
      set(value) {
        this.updateCategory(value);
      },
    },
  },
  methods: {
    ...mapMutations('note', ['updateCategory']),
  },
};
</script>
