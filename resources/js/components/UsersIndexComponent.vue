<template>
  <div id="showMembers">
    <div class="search_wrapper">
      <input type="text" v-model="search" class="input_text" placeholder="Search members">
    </div>
    <div class="radio-wrapper">
      <input
        class="input-radio"
        type="radio"
        v-model="orderBy"
        id="orderByGeneration"
        value="generation"
      >
      <label class="label-radio" for="orderByGeneration">入会期別</label>
      <input class="input-radio" type="radio" v-model="orderBy" id="orderByGroup" value="group_id">
      <label class="label-radio" for="orderByGroup">グループ別</label>
      <input
        type="radio"
        class="input-radio"
        v-model="orderBy"
        id="orderByDepartment"
        value="department_id"
      >
      <label for="orderByDepartment" class="label-radio">学部別</label>
    </div>
    <div class="no_border_card">
      <div v-if="orderBy == 'generation'">
        <user-container
          v-for="i in maxGeneration"
          :key="i"
          :index="i"
          :users="where(users, i)"
          :search="search"
          :orderBy="orderBy"
        ></user-container>
      </div>
      <div v-else-if="orderBy == 'group_id'">
        <user-container
          v-for="i in maxGroupId"
          :key="i"
          :index="i"
          :users="where(users, i)"
          :search="search"
          :orderBy="orderBy"
        ></user-container>
        <user-container :index="0" :users="where(users, 0)" :search="search" :orderBy="orderBy"></user-container>
        <user-container :index="-1" :users="where(users, -1)" :search="search" :orderBy="orderBy"></user-container>
      </div>
      <div v-else>
        <user-container
          v-for="i in maxDepartmentId"
          :key="i"
          :index="i"
          :users="where(users,i)"
          :search="search"
          :orderBy="orderBy"
        ></user-container>
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
      orderBy: "generation"
    };
  },
  methods: {
    where: function(users, i) {
      if (this.orderBy == "generation") {
        return users.filter(user => user.generation === i);
      } else if (this.orderBy == "group_id") {
        return users.filter(user => user.group_id === i);
      } else {
        return users.filter(user => user.department_id === i);
      }
    }
  },
  mounted() {
    if (sessionStorage.orderBy) {
      this.orderBy = sessionStorage.orderBy;
    }
    if (sessionStorage.search) {
      this.search = sessionStorage.search;
    }
  },
  watch: {
    orderBy(newOrderBy) {
      sessionStorage.orderBy = newOrderBy;
    },
    search(newSearch) {
      sessionStorage.search = newSearch;
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
    },
    maxDepartmentId: function() {
      var departmentId = this.users.map(function(user) {
        return user.department_id;
      });
      return Math.max.apply(null, departmentId);
    }
  }
};
</script>
