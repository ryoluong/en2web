<template>
  <v-list-item class="ma-auto py-1 px-6" ripple>
    <v-list-item-avatar large>
      <v-img :src="userImagePath" cover>
        <template v-slot:placeholder>
          <v-skeleton-loader class="mx-auto" type="image" />
        </template>
      </v-img>
    </v-list-item-avatar>
    <v-list-item-content>
      <v-list-item-title class="subtitle-1 font-weight-medium">
        {{ user.name }}
      </v-list-item-title>
    </v-list-item-content>
  </v-list-item>
</template>
<script>
export default {
  props: {
    user: {
      required: true,
      type: Object,
    },
  },
  computed: {
    userImagePath() {
      return this.user.avater_path
        ? this.user.avater_path
        : '/img/categories/user.png';
    },
  },
};
</script>
