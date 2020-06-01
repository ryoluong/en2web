<template>
  <v-app>
    <v-content>
      <Header />
      <router-view />
      <Snackbar />
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
