<template>
  <div class="flex_view">
    <a :href="userPageUrl">
      <v-lazy-image class="user_icon" :src="srcUrl" alt="user_icon"/>
    </a>
    <a class="user_name" :href="userPageUrl">{{ user.name }}</a>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    },
    orderBy: {
      type: String,
      required: true
    },
    showOB: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    userPageUrl() {
      return (
        "/users/" +
        this.user.id +
        "?orderBy=" +
        this.orderBy +
        "&showOB=" +
        [this.showOB ? 1 : 0]
      );
    },
    srcUrl() {
      if (this.user.avater_path) {
        return this.user.avater_path;
      } else {
        return "/img/categories/user.png";
      }
    }
  }
};
</script>
