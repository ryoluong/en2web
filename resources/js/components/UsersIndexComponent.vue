<template>
  <div id="showMembers">
    <div class="search_wrapper">
      <input type="text" v-model="search" class="input_text" placeholder="Search members">
    </div>
    <div class="no_border_card">
      <user-container
        v-for="i in max"
        :key="i"
        :generation="i"
        :users="where(users, i)"
        :search="search"
      ></user-container>
      <p v-if="!hasActiveUser" class="not-found">一致するユーザーは見つかりませんでした。</p>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    users: {
      type: Array,
      required: true
    },
    max: {
      type: Number,
      required: true
    }
  },
  data: function() {
    return {
      search: ""
    };
  },
  methods: {
    where: function(users, i) {
      return users.filter(user => user.generation === i);
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
    }
  }
};
</script>
