<template>
  <v-card tile max-width="450" elevation="8">
    <v-list-item class="ma-auto py-1">
      <v-list-item-avatar size="32">
        <v-img :src="userImagePath" cover>
          <template v-slot:placeholder>
            <v-skeleton-loader class="mx-auto" type="image" />
          </template>
        </v-img>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title class="subtitle-1 font-weight-medium">
          {{ note.user.name }}
        </v-list-item-title>
      </v-list-item-content>
      <v-list-item-content>
        <v-list-item-title
          class="body-2 text-right grey--text text--darken-1 mt-1"
        >
          {{ note.date }}
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-img
      class="v-img white--text align-start"
      height="220px"
      :src="noteImagePath"
    >
      <v-chip tile small class="white--text ma-2" color="indigo lighten-2">
        <v-icon small left>
          mdi-folder
        </v-icon>
        {{ note.category.name }}
      </v-chip>
      <template v-slot:placeholder>
        <v-skeleton-loader class="mx-auto" tile height="220px" type="image" />
      </template>
    </v-img>
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title class="title py-1 font-weight-bold" color="indigo">
          {{ note.title }}
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-card>
</template>
<script>
export default {
  props: {
    note: {
      type: Object,
      required: true,
    },
  },
  computed: {
    userImagePath() {
      return this.note.user.avater_path
        ? this.note.user.avater_path
        : '/img/categories/user.png';
    },
    noteImagePath() {
      return this.note.photos.length
        ? this.note.photos[0]['path']
        : `/img/note_cover_photo/${this.note.category_id}.jpg`;
    },
    // display() {
    //   const offset = window.pageYOffset;
    //   console.log(this.$el);
    //   const rect = this.$el.getBoundingClientRect();
    //   return offset < rect.bottom && rect.top < offset;
    // },
  },
};
</script>
