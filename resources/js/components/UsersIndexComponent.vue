<template>
  <div id="showMembers">
    <div class="search_wrapper">
      <input type="text" v-model="search" class="input_text" placeholder="Search members">
    </div>
    <div class="radio-wrapper">
      <input
        class="input-radio"
        type="radio"
        v-model="showBy"
        id="showByGeneration"
        value="generation"
      >
      <label class="label-radio" for="showByGeneration">入会期別</label>
      <input class="input-radio" type="radio" v-model="showBy" id="showByGroup" value="group">
      <label class="label-radio" for="showByGroup">グループ別</label>
    </div>
    <div class="no_border_card">
      <div v-if="showBy == 'generation'">
        <user-container
          v-for="i in maxGeneration"
          :key="i"
          :index="i"
          :users="where(users, i)"
          :search="search"
          :showBy="showBy"
        ></user-container>
      </div>
      <div v-else>
        <user-container
          v-for="i in maxGroupId"
          :key="i"
          :index="i"
          :users="where(users, i)"
          :search="search"
          :showBy="showBy"
        ></user-container>
        <user-container :index="0" :users="where(users, 0)" :search="search" :showBy="showBy"></user-container>
        <user-container :index="-1" :users="where(users, -1)" :search="search" :showBy="showBy"></user-container>
      </div>
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
    }
  },
  data: function() {
    return {
      search: "",
      showBy: "generation"
    };
  },
  methods: {
    where: function(users, i) {
      if (this.showBy == "generation") {
        return users.filter(user => user.generation === i);
      } else {
        return users.filter(user => user.group_id === i);
      }
    }
  },
  mounted() {
    if (localStorage.showBy) {
      this.showBy = localStorage.showBy;
    }
  },
  watch: {
    showBy(newShowBy) {
      localStorage.showBy = newShowBy;
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
    maxGroupId: function() {
      var groupId = this.users.map(function(user) {
        return user.group_id;
      });
      return Math.max.apply(null, groupId);
    },
    maxGeneration: function() {
      var generation = this.users.map(function(user) {
        return user.generation;
      });
      return Math.max.apply(null, generation);
    }
  }
};
</script>
