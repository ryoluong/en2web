<template>
  <div class="wrapper max-width">
    <v-tabs
      v-model="showBy"
      color="indigo lighten-1"
      grow
      centered
      class="mb-2"
    >
      <v-tab>現役</v-tab>
      <v-tab>OG/OB</v-tab>
      <v-tab>ALL</v-tab>
    </v-tabs>
    <v-radio-group
      v-model="groupBy"
      class="pt-3"
      row
      background-color="white"
      hide-details
    >
      <v-radio
        color="indigo lighten-1"
        class="ma-auto"
        label="学部別"
        value="department"
      />
      <v-radio
        color="indigo lighten-1"
        class="ma-auto"
        label="入会時期別"
        value="generation"
      />
      <v-radio
        color="indigo lighten-1"
        class="ma-auto"
        label="グループ別"
        value="group"
        :disabled="showBy === '1'"
      />
    </v-radio-group>
    <v-text-field
      v-model="search"
      solo
      single-line
      flat
      hide-details
      label="Seach"
      prepend-inner-icon="mdi-magnify"
      color="indigo"
      height="56px"
      class="pt-3"
    />
    <div v-if="loading">
      <v-skeleton-loader class="mt-2 mx-auto" type="card-heading" />
      <v-skeleton-loader
        v-for="i in 6"
        :key="i"
        class="ml-2 mt-5 mr-12"
        type="list-item-avatar"
      />
    </div>
    <v-expansion-panels
      v-if="!loading"
      v-model="panel"
      multiple
      accordion
      tile
      flat
    >
      <template v-if="groupBy === 'department'">
        <UserGroup
          v-for="i in maxDepartmentId"
          :key="i"
          :index="i"
          :users="where(i)"
          :subheader="departments[i - 1]"
        />
      </template>
      <template v-else-if="groupBy === 'group'">
        <UserGroup
          v-for="i in maxGroupId"
          :key="i"
          :index="i"
          :users="where(i)"
          :subheader="`Group${i}`"
        />
        <UserGroup
          :key="-1"
          :index="-1"
          :users="where(-1)"
          :subheader="'OG/OB'"
        />
      </template>
      <template v-else-if="groupBy === 'generation'">
        <UserGroup
          v-for="i in maxGeneration"
          :key="i"
          :index="i"
          :users="where(i)"
          :subheader="`${i}期生`"
        />
      </template>
    </v-expansion-panels>
  </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex';
import UserGroup from '@/js/components/users/UserGroup.vue';

export default {
  components: {
    UserGroup,
  },
  data: () => ({
    loading: true,
    panel: [...Array(20).keys()],
  }),
  computed: {
    ...mapState('user', ['users']),
    showBy: {
      get() {
        return this.$store.state.user.showBy;
      },
      set(v) {
        this.updateShowBy(v);
      },
    },
    groupBy: {
      get() {
        return this.$store.state.user.groupBy;
      },
      set(v) {
        this.panel = [...Array(20).keys()];
        this.updateGroupBy(v);
      },
    },
    search: {
      get() {
        return this.$store.state.user.search;
      },
      set(v) {
        this.updateSearch(v);
      },
    },
    maxGeneration() {
      const generation = this.users.map((user) => {
        return user.generation;
      });
      return Math.max.apply(null, generation);
    },
    maxDepartmentId() {
      const departmentIds = this.users.map(function (user) {
        return user.department_id;
      });
      return Math.max.apply(null, departmentIds);
    },
    maxGroupId: function () {
      const groupIds = this.users.map(function (user) {
        return user.group_id;
      });
      return Math.max.apply(null, groupIds);
    },
    departments() {
      return ['経済学部', '経営学部', '教育学部', '都市科学部', '理工学部'];
    },
    displayUsers() {
      let users = this.users;
      if (this.search !== '') {
        users = users.filter(
          (user) =>
            user.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1,
        );
      }
      switch (this.showBy) {
        case 0:
          return users.filter((user) => {
            return user.isOB === 0;
          });
        case 1:
          return users.filter((user) => {
            return user.isOB === 1;
          });
        case 2:
          return users;
        default:
          return null;
      }
    },
  },
  async created() {
    if (this.users.length === 0) {
      await this.$store.dispatch('user/index');
    }
    this.loading = false;
  },
  methods: {
    ...mapMutations('user', ['updateShowBy', 'updateGroupBy', 'updateSearch']),
    where(i) {
      switch (this.groupBy) {
        case 'department':
          return this.displayUsers.filter((user) => user.department_id === i);
        case 'group':
          return this.displayUsers.filter((user) => user.group_id === i);
        case 'generation':
          return this.displayUsers.filter((user) => user.generation === i);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.wrapper {
  background: white !important;
  min-height: 100vh;
}
</style>
