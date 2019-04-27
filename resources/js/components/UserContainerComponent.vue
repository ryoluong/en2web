<template>
  <transition name="fade-no-slide" mode="in-out" style="position:relative;">
    <div class="flex_container" v-if="hasActiveUser">
      <div class="subtitle">
        <p v-if="orderBy == 'generation'">{{ formattedNumber }}</p>
        <p
          v-else-if="orderBy == 'group_id'"
        >{{ index == -1 ? 'OB・OG' : index == 0 ? 'No Group' : 'Group ' + index }}</p>
        <p v-else>{{ departments[index - 1] }}</p>
      </div>
      <div class="toggle-display" @click="toggleDisplay" :class="{ rotate180: !display}">
        <i class="fas fa-chevron-down"></i>
      </div>
      <!-- <transition name="fade-no-slide"> -->
      <transition-group
        class="user-items-wrapper"
        name="flip"
        tag="div"
        v-if="display"
        style="width: 100%; display:flex; flex-wrap:wrap;"
      >
        <user-item
          v-for="user in users"
          :user="user"
          :key="user.id"
          :orderBy="orderBy"
          :showOB="showOB"
        ></user-item>
      </transition-group>
      <!-- </transition> -->
    </div>
  </transition>
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
    orderBy: {
      type: String,
      required: true
    },
    showOB: {
      type: Boolean,
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
      ],
      display: true
    };
  },
  computed: {
    hasActiveUser: function() {
      return this.users.length !== 0;
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
  },
  methods: {
    toggleDisplay() {
      this.display = !this.display;
    }
  }
};
</script>
