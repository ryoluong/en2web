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
    <div class="radio-wrapper">
      <input class="input-checkbox" id="showOB" type="checkbox" v-model="showOB" value="1">
      <label for="showOB">OB・OGを表示する</label>
    </div>
    <div class="no_border_card">
      <transition name="fade-no-slide">
        <p v-if="!hasActiveUser" class="not-found">一致するユーザーは見つかりませんでした。</p>
      </transition>
      <transition name="fade" mode="out-in">
        <div v-if="orderBy == 'generation'" key="generation">
          <user-container
            v-for="i in maxGeneration"
            :key="i"
            :index="i"
            :users="where(users, i)"
            :orderBy="orderBy"
            :showOB="showOB"
          ></user-container>
        </div>
        <div v-else-if="orderBy == 'group_id'" key="group_id">
          <user-container
            v-for="i in groupIdArray"
            :key="i"
            :index="i"
            :users="where(users, i)"
            :orderBy="orderBy"
            :showOB="showOB"
          ></user-container>
        </div>
        <div v-else key="department_id">
          <user-container
            v-for="i in maxDepartmentId"
            :key="i"
            :index="i"
            :users="where(users,i)"
            :orderBy="orderBy"
            :showOB="showOB"
          ></user-container>
        </div>
      </transition>
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
      orderBy: sessionStorage.orderBy ? sessionStorage.orderBy : "generation",
      showOB: false
    };
  },
  methods: {
    where: function(users, i) {
      if (!this.showOB) {
        users = users.filter(user => user.isOB === 0);
      }
      if (this.search !== "") {
        users = users.filter(
          user =>
            user.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
        );
      }
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
    if (sessionStorage.showOB) {
      this.showOB = sessionStorage.showOB == "true" ? true : false;
    }
  },
  watch: {
    orderBy(newOrderBy) {
      sessionStorage.orderBy = newOrderBy;
    },
    search(newSearch) {
      sessionStorage.search = newSearch;
    },
    showOB(newShowOB) {
      sessionStorage.showOB = newShowOB;
    }
  },
  computed: {
    hasActiveUser: function() {
      var users = this.users;
      if (!this.showOB) {
        users = users.filter(user => user.isOB === 0);
      }
      for (var i = 0; i < users.length; i++) {
        if (
          users[i].name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
        ) {
          return true;
        }
      }
      return false;
    },
    groupIdArray: function() {
      var array1 = [-1];
      var array2 = [];
      var array3 = [0];
      for (var i = 1; i <= this.maxGroupId; i++) {
        array2.push(i);
      }
      return array1.concat(array2.concat(array3));
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
