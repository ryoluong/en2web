<!-- eslint-disable vue/no-v-html -->
<template>
  <div class="max-width">
    <div v-if="!loading" class="top" :style="topStyle">
      <v-avatar class="user-image" size="95">
        <v-img :src="userImagePath" :alt="user.name" />
      </v-avatar>
      <div
        class="user-name headline white--text mt-4 d-flex justify-center align-center"
      >
        <p class="mb-0">
          {{ user.name }}
        </p>
        <v-chip
          v-if="user.isOB"
          class="my-0 mx-3 px-1"
          color="cyan darken-2 white--text"
          small
          label
        >
          OG･OB
        </v-chip>
        <v-chip
          v-if="user.isOverseas"
          class="my-0 mx-3 px-1"
          color="deep-orange white--text"
          small
          label
        >
          留学中
        </v-chip>
      </div>
    </div>
    <v-skeleton-loader v-else max-height="180px" type="image" />
    <v-tabs v-model="tab" color="indigo lighten-1" grow centered class="mb-2">
      <v-tab>
        Profile
      </v-tab>
      <v-tab>
        Notes
      </v-tab>
    </v-tabs>
    <div v-if="!loading">
      <div v-if="tab === 0" class="pb-10">
        <v-list flat>
          <v-list-item v-for="(p, i) in profile" :key="i" class="px-3">
            <v-list-item-icon>
              <v-icon size="28" color="#559" v-text="p.icon" />
            </v-list-item-icon>
            <v-list-item-content>
              {{ p.value }}
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <div
          v-if="user.escaped_profile"
          class="profile mt-3 mx-auto"
          v-html="user.escaped_profile"
        />
        <IconMessage
          v-else
          icon="mdi-snowboard"
          message="プロフィールが未記入です。"
        />
      </div>
      <div v-else>
        <NoteCard
          v-for="n in user.notes"
          :key="n.id"
          :note="n"
          class="mx-auto mt-8 my-12"
          @fav="handleFav"
        />
        <IconMessage
          v-if="user.notes_count === 0"
          icon="mdi-snowboard"
          message="ノートがまだありません。"
        />
        <Period v-else-if="0 < user.notes_count && user.notes_count < 5" />
        <div v-else class="d-flex justify-center">
          <v-btn
            large
            rounded
            class="mx-auto px-12 mb-11 white--text"
            color="blue-grey"
            :to="`/notes?user_id=${user.id}`"
          >
            See all {{ user.notes_count }} notes
          </v-btn>
        </div>
      </div>
    </div>
    <div v-else class="mt-5">
      <v-skeleton-loader class="px-3" type="list-item" />
      <v-skeleton-loader class="px-3" type="list-item" />
      <v-skeleton-loader class="px-3" type="list-item" />
    </div>
  </div>
</template>
<script>
import { mapState, mapActions, mapMutations } from 'vuex';
import IconMessage from '@/js/components/IconMessage.vue';
import Period from '@/js/components/notes/Period.vue';
import NoteCard from '@/js/components/notes/NoteCard.vue';
export default {
  components: { IconMessage, Period, NoteCard },
  data: () => ({
    user: null,
    loading: true,
    tab: 0,
  }),
  computed: {
    ...mapState('user', ['noteTabUserId']),
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
      if (this.university != null) {
        profile.push(this.university);
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
    university() {
      if (this.user.university) {
        return {
          icon: 'mdi-map-marker',
          value: this.user.university,
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
    topStyle() {
      return this.loading
        ? {}
        : {
            backgroundImage: `url(${this.coverImagePath})`,
          };
    },
  },
  watch: {
    $route: async function () {
      this.loading = true;
      const id =
        this.$route.path === '/mypage'
          ? this.$store.state.auth.user.id
          : this.$route.params.id;
      this.user = await this.$store.dispatch('user/get', id);
      this.tab = 0;
      this.loading = false;
    },
  },
  async created() {
    const id =
      this.$route.path === '/mypage'
        ? this.$store.state.auth.user.id
        : this.$route.params.id;
    this.user = await this.$store.dispatch('user/get', id);
    if (this.noteTabUserId === this.user.id) {
      this.tab = 1;
    } else {
      this.setNoteTabUserId(0);
    }
    this.loading = false;
  },
  beforeDestroy() {
    if (this.tab === 1) {
      this.setNoteTabUserId(this.user.id);
    }
  },
  methods: {
    ...mapActions('note', ['fav']),
    ...mapMutations('user', ['setNoteTabUserId']),
    handleFav(noteId) {
      const isFavNote = this.$store.state.note.favNotes.indexOf(noteId) !== -1;
      this.user.notes.some(note => {
        if (note.id === noteId)
          isFavNote ? note.fav_users_count-- : note.fav_users_count++;
      });
      this.fav(noteId);
    },
  },
};
</script>
<style lang="scss" scoped>
@import '@/sass/_variables.scss';
.avatar {
  border-radius: 20%;
  margin-left: 10px;
  margin-top: -50px;
}
.name {
  line-height: 46px !important;
}
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
