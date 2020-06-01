<template>
  <v-list dense>
    <v-list-item
      v-for="i in items"
      :key="i.name"
      link
      :to="i.to"
      color="indigo"
    >
      <v-list-item-action>
        <v-icon>{{ i.icon }}</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>{{ i.name }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>
<script>
export default {
  data: () => ({
    items: [
      {
        to: '/login',
        icon: 'mdi-account-key',
        name: 'Login',
      },
      {
        to: '/password/reset',
        icon: 'mdi-account-question',
        name: 'Reset Password',
      },
    ],
  }),
};
</script>
