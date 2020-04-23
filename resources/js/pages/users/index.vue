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
      <UserGroup
        v-for="(chunk, i) in usersChunk"
        :key="`chunk${i}`"
        :index="i"
        :users="chunk.users"
        :subheader="chunk.header"
      />
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
      const generation = this.users.map(user => {
        return user.generation;
      });
      return Math.max.apply(null, generation);
    },
    maxGroupId() {
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
          user =>
            user.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1,
        );
      }
      switch (this.showBy) {
        case 0:
          return users.filter(user => {
            return user.isOB === 0;
          });
        case 1:
          return users.filter(user => {
            return user.isOB === 1;
          });
        case 2:
          return users;
        default:
          return null;
      }
    },
    usersChunk() {
      const chunk = [];
      switch (this.groupBy) {
        case 'department':
          this.departments.forEach((d, i) => {
            chunk.push({
              header: d,
              users: this.displayUsers.filter(
                user => user.department_id == i + 1,
              ),
            });
          });
          break;
        case 'generation':
          [...Array(this.maxGeneration).keys()].forEach(i => {
            chunk.push({
              header: `${i + 1}期生`,
              users: this.displayUsers.filter(
                user => user.generation === i + 1,
              ),
            });
          });
          break;
        case 'group':
          [...Array(this.maxGroupId).keys()].forEach(i => {
            chunk.push({
              header: `Group${i + 1}`,
              users: this.displayUsers.filter(user => user.group_id === i + 1),
            });
          });
          chunk.push({
            header: 'OG/OB',
            users: this.displayUsers.filter(user => user.group_id === -1),
          });
          break;
      }
      return chunk;
    },
  },
  async created() {
    if (this.users.length === 0) {
      await this.$store.dispatch('user/index');
    }
    this.loading = false;
  },
  beforeDestroy() {
    let userIds = [];
    this.usersChunk.forEach(chunk => {
      userIds = userIds.concat(chunk.users.map(u => u.id));
    });
    this.setDisplayUserIds(userIds);
  },
  methods: {
    ...mapMutations('user', [
      'updateShowBy',
      'updateGroupBy',
      'updateSearch',
      'setDisplayUserIds',
    ]),
  },
};
</script>
<style lang="scss" scoped>
.wrapper {
  background: white !important;
  min-height: 100vh;
}
</style>
