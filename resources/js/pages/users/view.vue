<template>
  <div v-if="loading">
    Loading
  </div>
  <div v-else class="pb-8">
    <div class="top" :style="`background-image:url(${coverImagePath});`">
      <v-avatar class="user-image" size="95">
        <v-img v-if="!loading" :src="userImagePath" :alt="user.name" />
      </v-avatar>
      <div class="user-name headline white--text mt-4">
        {{ user.name }}
      </div>
    </div>
    <v-tabs v-model="tab" color="indigo lighten-1" grow centered class="mb-2">
      <v-tab>Profile</v-tab>
      <v-tab>Notes</v-tab>
    </v-tabs>
    <div v-if="tab == 0">
      <v-list flat>
        <v-list-item v-for="(p, i) in profile" :key="i" class="px-3">
          <v-list-item-icon>
            <v-icon size="28" color="#559" v-text="p.icon" />
          </v-list-item-icon>
          <v-list-item-content>
            <!-- <p v-text="p.value" /> -->{{ p.value }}
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <!-- eslint-disable-next-line vue/no-v-html -->
      <div class="profile mt-3 mx-auto" v-html="user.profile" />
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    user: null,
    loading: true,
    tab: 0,
  }),
  computed: {
    profile() {
      let profile = [
        {
          icon: 'mdi-school',
          value: `${this.user.department} ${this.user.major}`,
        },
        {
          icon: 'mdi-account-multiple',
          value: this.enrollment,
        },
      ];
      if (this.countries != null) {
        profile.push(this.countries);
      }
      if (this.job != null) {
        profile.push(this.job);
      }
      return profile;
    },
    enrollment() {
      let text = this.user.year;
      text += this.user.isHennyu ? '年編入' : '年入学';
      text += ` ${this.user.generation}期生`;
      return text;
    },
    job() {
      if (this.user.job) {
        return {
          icon: 'mdi-routes',
          value: this.user.job,
        };
      } else {
        return null;
      }
    },
    countries() {
      if (this.user.countries.length > 0) {
        return {
          icon: 'mdi-earth',
          value: this.user.countries.map(c => c.name).join(', '),
        };
      } else {
        return null;
      }
    },
    userImagePath() {
      return this.user.avater_path
        ? this.user.avater_path
        : '/img/categories/user.png';
    },
    coverImagePath() {
      return this.user.coverimg_path
        ? this.user.coverimg_path
        : '/img/cover_photo.jpg';
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
<style lang="scss" scoped>
@import '@/sass/_variables.scss';
.top {
  width: 100%;
  height: 180px;
  display: flex;
  justify-content: center;
  align-items: center;
  align-content: center;
  flex-wrap: wrap;
  position: relative;
  background-size: cover;
  background-position: center;
  z-index: 1;
  .user-name {
    width: 100%;
    text-align: center;
  }
  &::after {
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    background: linear-gradient(
      rgba($color: $indigo-darken3, $alpha: 0.3),
      rgba($color: $indigo-darken3, $alpha: 0.95)
    );
    content: '';
    z-index: -1;
  }
}
.profile {
  width: 93%;
  line-height: 1.8;
  font-size: 16px;
}
</style>
