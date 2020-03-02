<template>
  <v-app id="inspire">
    <v-content id="main">
      <Header />
      <router-view id="router-view" />
      <Snackbar class="snackbar" />
    </v-content>
  </v-app>
</template>

<script>
import Header from '@/js/components/Header.vue';
import Snackbar from '@/js/components/Snackbar.vue';
export default {
  name: 'App',
  components: {
    Header,
    Snackbar,
  },
};
</script>
