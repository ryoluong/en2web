<template>
  <div class="flex_view" v-if="displayUser">
    <a :href="'/users/'+user.id">
      <img
        class="user_icon"
        :src="[ user.avater_path ? user.avater_path : '/img/categories/user.png']"
        alt="user_icon"
      >
    </a>
    <a
      class="user_name"
      :href="'/users/' + user.id + '?showBy=' + showBy + [ search ? '?q=' + search : '']"
    >{{ user.name }}</a>
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
      required: false
    }
  },
  computed: {
    displayUser: function() {
      if (
        this.search == "" ||
        this.user.name.toLowerCase().indexOf(this.search.toLowerCase()) != -1
      ) {
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>
