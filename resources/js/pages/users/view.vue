<template>
  <div v-if="loading">
    Loading
  </div>
  <div v-else>
    <v-img
      height="150px"
      :src="user.coverimg_path ? user.coverimg_path : '/img/coverimg.jpeg'"
    />
    <div class="d-flex">
      <v-avatar class="avatar" size="100px" tile>
        <v-img :src="userImagePath" cover />
      </v-avatar>
      <p class="title name ma-0">
        {{ user.name }}
      </p>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    user: null,
    loading: true,
  }),
  computed: {
    userImagePath() {
      return this.user.avater_path
        ? this.user.avater_path
        : '/img/categories/user.png';
    },
  },
  async created() {
    this.user = await this.$store.dispatch('user/get', this.$route.params.id);
    this.loading = false;
  },
};
</script>
<style lang="scss" scoped>
.avatar {
  border-radius: 20%;
  margin-left: 10px;
  margin-top: -50px;
}
.name {
  line-height: 46px !important;
}
</style>
