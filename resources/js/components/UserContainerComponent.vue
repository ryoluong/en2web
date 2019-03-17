<template>
  <div class="flex_container" v-if="hasActiveUser">
    <div class="subtitle">
      <p>{{ formattedNumber }}</p>
    </div>
    <user-item v-for="user in users" :user="user" :key="user.id" :search="search"></user-item>
  </div>
</template>
<script>
export default {
  props: {
    generation: {
      type: Number,
      required: true
    },
    users: {
      type: Array,
      required: true
    },
    search: {
      type: String,
      required: true
    }
  },
  computed: {
    hasActiveUser: function() {
      for (var i = 0; i < this.users.length; i++) {
        if (
          this.users[i].name
            .toLowerCase()
            .indexOf(this.search.toLowerCase()) !== -1
        ) {
          return true;
        }
      }
      return false;
    },
    formattedNumber: function() {
      var num = this.generation % 10;
      if (num == 1) {
        return num + "st";
      } else if (num == 2) {
        return num + "nd";
      } else if (num == 3) {
        return num + "rd";
      } else {
        return num + "th";
      }
    }
  }
};
</script>
