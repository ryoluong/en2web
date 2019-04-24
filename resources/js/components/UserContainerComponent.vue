<template>
  <div class="flex_container" v-if="hasActiveUser">
    <div class="subtitle">
      <p v-if="orderBy == 'generation'">{{ formattedNumber }}</p>
      <p
        v-else-if="orderBy == 'group_id'"
      >{{ index == -1 ? 'OB・OG' : index == 0 ? 'No Group' : 'Group ' + index }}</p>
      <p v-else>{{ departments[index - 1] }}</p>
    </div>
    <user-item
      v-for="user in users"
      :user="user"
      :key="user.id"
      :search="search"
      :orderBy="orderBy"
    ></user-item>
  </div>
</template>
<script>
export default {
  props: {
    index: {
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
    },
    orderBy: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      departments: [
        "経済学部",
        "経営学部",
        "教育学部",
        "都市科学部",
        "理工学部"
      ]
    };
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
      var num = this.index % 10;
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
