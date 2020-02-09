<template>
  <div class="wrapper mx-auto">
    <v-tabs
      v-model="groupBy"
      color="indigo lighten-1"
      grow
      centered
      class="mb-2"
    >
      <v-tab>学部別</v-tab>
      <v-tab>グループ別</v-tab>
      <v-tab>入会時期別</v-tab>
    </v-tabs>
    <v-radio-group
      v-model="filter"
      class=""
      row
      background-color="white"
      hide-details
    >
      <v-radio
        color="indigo lighten-1"
        class="ma-auto"
        label="現役"
        value="active"
      />
      <v-radio
        color="indigo lighten-1"
        class="ma-auto"
        label="OG/OB"
        value="ogob"
      />
      <v-radio
        color="indigo lighten-1"
        class="ma-auto"
        label="ALL"
        value="all"
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
      class="mt-2 mx-2"
    />
    <div v-if="loading">
      <v-skeleton-loader class="mt-2 mx-auto" type="card-heading" />
      <v-skeleton-loader
        v-for="i in 6"
        :key="i"
        class="ml-5 mt-3 mr-12"
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
      <template v-if="groupBy === 0">
        <UserGroup
          v-for="i in maxDepartmentId"
          :key="i"
          :index="i"
          :users="where(i)"
          :subheader="departments[i - 1]"
        />
      </template>
      <template v-else-if="groupBy === 1">
        <UserGroup
          v-for="i in maxGroupId"
          :key="i"
          :index="i"
          :users="where(i)"
          :subheader="`Group${i}`"
        />
      </template>
      <template v-else-if="groupBy === 2">
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
import UserGroup from '@/components/users/UserGroup.vue';

const ALL = 'all';
const ACTIVE = 'active';
const OGOB = 'ogob';

const TAB_DEPARTMENT = 0;
const TAB_GROUP = 1;
const TAB_GENERATION = 2;

export default {
  components: {
    UserGroup,
  },
  data: () => ({
    loading: true,
    users: [],
    panel: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    filter: ACTIVE,
    search: '',
    groupBy: TAB_DEPARTMENT,
  }),
  computed: {
    maxGeneration() {
      const generation = this.users.map(user => {
        return user.generation;
      });
      return Math.max.apply(null, generation);
    },
    maxDepartmentId() {
      const departmentIds = this.users.map(function(user) {
        return user.department_id;
      });
      return Math.max.apply(null, departmentIds);
    },
    maxGroupId: function() {
      const groupIds = this.users.map(function(user) {
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
          user =>
            user.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1,
        );
      }
      switch (this.filter) {
        case ACTIVE:
          return users.filter(user => {
            return user.isOB === 0;
          });
        case OGOB:
          return users.filter(user => {
            return user.isOB === 1;
          });
        case ALL:
          return users;
        default:
          return null;
      }
    },
  },
  async created() {
    this.users = await this.$store.dispatch('user/index');
    this.loading = false;
  },
  methods: {
    where(i) {
      switch (this.groupBy) {
        case TAB_DEPARTMENT:
          return this.displayUsers.filter(user => user.department_id === i);
        case TAB_GROUP:
          return this.displayUsers.filter(user => user.group_id === i);
        case TAB_GENERATION:
          return this.displayUsers.filter(user => user.generation === i);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.wrapper {
  background: white !important;
  max-width: 500px;
}
</style>
