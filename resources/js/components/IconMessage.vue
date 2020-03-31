<template>
  <div class="d-flex justify-center align-center pt-6">
    <v-icon class="mr-2">
      {{ icon }}
    </v-icon>
    <p class="ma-0 grey--text text--darken-2">
      {{ message }}
    </p>
  </div>
</template>
<script>
export default {
  props: {
    icon: {
      required: true,
      type: String,
    },
    message: {
      required: true,
      type: String,
    },
  },
};
</script>
