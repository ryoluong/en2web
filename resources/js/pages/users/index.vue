<template>
  <div>
    <v-tabs v-model="showOB" color="indigo lighten-1" show-arrows centered grow>
      <v-tab>現役</v-tab>
      <v-tab>OG/OB</v-tab>
    </v-tabs>
    <v-tabs v-model="showBy" color="teal lighten-1" centered grow>
      <v-tab>学部別</v-tab>
      <v-tab>入会期別</v-tab>
      <v-tab>グループ別</v-tab>
    </v-tabs>
    <v-text-field
      solo
      label="Seach"
      prepend-inner-icon="mdi-magnify"
      color="indigo"
      hide-details
      flat
      height="52px"
    />
    <v-expansion-panels v-if="!loading" v-model="panel" multiple accordion tile>
      <UserGroup
        v-for="i in maxGeneration"
        :key="i"
        :index="i"
        :users="where(i)"
        :subheader="`${i}期生`"
      />
    </v-expansion-panels>
  </div>
</template>
<script>
import UserGroup from '@/components/users/UserGroup.vue';
export default {
  components: {
    UserGroup,
  },
  data: () => ({
    loading: true,
    users: [],
    panel: [0, 1, 2, 3, 4, 5],
    showOB: 0,
    showBy: 0,
  }),
  computed: {
    maxGeneration() {
      const generation = this.users.map(user => {
        return user.generation;
      });
      return Math.max.apply(null, generation);
    },
    displayUsers() {
      return this.users.filter(user => {
        return user.isOB === this.showOB;
      });
    },
  },
  async created() {
    this.users = await this.$store.dispatch('user/index');
    this.loading = false;
  },
  methods: {
    where(i) {
      // if (!this.showOB) {
      //   users = users.filter(user => user.isOB === 0);
      // }
      // if (this.search !== '') {
      //   users = users.filter(
      //     user =>
      //       user.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1,
      //   );
      // }
      // if (this.orderBy == 'generation') {
      return this.displayUsers.filter(user => user.generation === i);
      // } else if (this.orderBy == 'group_id') {
      //   return users.filter(user => user.group_id === i);
      // } else {
      //   return users.filter(user => user.department_id === i);
      // }
    },
  },
};
</script>
