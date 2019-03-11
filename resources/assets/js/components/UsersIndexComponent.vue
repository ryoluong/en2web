<template>
  <div class="flex_view" v-if="display">
    <a :href="'/users/'+user.id">
      <img
        class="user_icon"
        :src="[ user.avater_path ? user.avater_path : '/img/categories/user.png']"
        alt="user_icon"
      >
    </a>
    <a class="user_name" :href="'/users/'+user.id">{{ user.name }}</a>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    },
    search: {
      type: String,
      required: true
    }
  },
  data: function() {
    return {
      username: this.user.name
    };
  },
  computed: {
    display: function() {
      if (
        this.search == "" ||
        this.user.name.toLowerCase().indexOf(this.search) != -1
      ) {
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>
