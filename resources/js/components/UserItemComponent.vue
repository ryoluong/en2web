<template>
  <div class="flex_view">
    <a :href="userPageUrl">
      <img
        class="user_icon"
        :src="[ user.avater_path ? user.avater_path : '/img/categories/user.png']"
        alt="user_icon"
      >
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
    }
  }
};
</script>
