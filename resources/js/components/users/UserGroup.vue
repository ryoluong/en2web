<template>
  <v-expansion-panel>
    <v-expansion-panel-header
      ripple
      class="body-1 font-weight-bold blue-grey--text text--darken-3"
    >
      {{ subheader }}
    </v-expansion-panel-header>
    <v-expansion-panel-content>
      <User v-for="user in users" :key="user.id" :user="user" />
    </v-expansion-panel-content>
  </v-expansion-panel>
</template>
<script>
import User from '@/components/users/User.vue';
export default {
  components: {
    User,
  },
  props: {
    subheader: {
      required: true,
      type: String,
    },
    users: {
      required: true,
      type: Array,
    },
  },
};
</script>
