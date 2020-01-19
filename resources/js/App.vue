<template>
  <v-app id="inspire">
    <Header />
    <v-content>
      <router-view id="main" style="max-width:800px;margin:auto;" />
      <Snackbar class="snackbar" />
    </v-content>
  </v-app>
</template>

<script>
import Header from '@/components/Header.vue';
import Snackbar from '@/components/Snackbar.vue';
export default {
  name: 'App',
  components: {
    Header,
    Snackbar,
  },
};
</script>
